import instaloader
from xml.etree.ElementTree import Element, SubElement, tostring, register_namespace
from xml.dom import minidom
import datetime
import re
import logging
import os
import shutil
import tkinter as tk
from tkinter import filedialog, messagebox
import ttkbootstrap as ttk
from ttkbootstrap.constants import *
import threading

# ---------------------------- Functionality Classes ---------------------------- #

class InstagramToWXRExporter:
    def __init__(self, username, media_dest_folder, media_base_url, output_xml_file="instagram_posts_wxr.xml", start_post_id=1000, language_code="en"):
        self.username = username
        self.media_dest_folder = media_dest_folder
        self.media_base_url = media_base_url.rstrip('/')  # Ensure no trailing slash
        self.output_xml_file = output_xml_file
        self.start_post_id = start_post_id
        self.language_code = language_code
        self.post_id_counter = start_post_id
        self.L = instaloader.Instaloader()
        self.setup_logging()
        self.register_namespaces()

    def setup_logging(self):
        # Create a logger
        self.logger = logging.getLogger("InstagramToWXRExporter")
        self.logger.setLevel(logging.INFO)

        # Create console handler and set level to info
        ch = logging.StreamHandler()
        ch.setLevel(logging.INFO)

        # Create formatter
        formatter = logging.Formatter('%(levelname)s: %(message)s')

        # Add formatter to ch
        ch.setFormatter(formatter)

        # Add ch to logger
        self.logger.addHandler(ch)

    def register_namespaces(self):
        # Register namespaces to prevent duplicate xmlns attributes
        register_namespace('excerpt', 'http://wordpress.org/export/1.2/excerpt/')
        register_namespace('content', 'http://purl.org/rss/1.0/modules/content/')
        register_namespace('wfw', 'http://wellformedweb.org/CommentAPI/')
        register_namespace('dc', 'http://purl.org/dc/elements/1.1/')
        register_namespace('wp', 'http://wordpress.org/export/1.2/')

    def login_if_needed(self, username=None, password=None):
        # Optional: Log in to Instagram if needed
        # Uncomment and use if you need to access private profiles or more data
        if username and password:
            try:
                self.L.login(username, password)
                self.logger.info("Logged in to Instagram successfully.")
            except Exception as e:
                self.logger.error(f"Failed to log in to Instagram: {e}")
                raise

    def fetch_profile(self):
        try:
            profile = instaloader.Profile.from_username(self.L.context, self.username)
            self.logger.info(f"Successfully loaded profile: {profile.username}")
            return profile
        except Exception as e:
            self.logger.error(f"Error loading profile '{self.username}': {e}")
            raise

    def create_wxr_structure(self, profile):
        # Create the root <rss> element
        rss = Element("rss", {"version": "2.0"})

        # Create the <channel> element
        channel = SubElement(rss, "channel")

        # Add basic channel information
        SubElement(channel, "title").text = "Instagram Posts Export"
        SubElement(channel, "link").text = f"https://www.instagram.com/{profile.username}/"
        SubElement(channel, "description").text = f"Exported Instagram posts from {profile.username}"

        # Add additional channel information
        current_time = datetime.datetime.now(datetime.timezone.utc)
        SubElement(channel, "pubDate").text = current_time.strftime("%a, %d %b %Y %H:%M:%S +0000")
        SubElement(channel, "language").text = self.language_code
        SubElement(channel, "{http://wordpress.org/export/1.2/}wxr_version").text = "1.2"
        SubElement(channel, "{http://wordpress.org/export/1.2/}base_site_url").text = f"https://www.instagram.com/{profile.username}/"
        SubElement(channel, "{http://wordpress.org/export/1.2/}base_blog_url").text = f"https://www.instagram.com/{profile.username}/"

        # Add generator information
        SubElement(channel, "generator").text = "Custom Instagram to WXR Exporter"

        # Add Author Information
        author = SubElement(channel, "{http://wordpress.org/export/1.2/}author")
        SubElement(author, "{http://wordpress.org/export/1.2/}author_id").text = "1"
        SubElement(author, "{http://wordpress.org/export/1.2/}author_login").text = profile.username
        SubElement(author, "{http://wordpress.org/export/1.2/}author_email").text = "info@example.com"  # Replace with actual email
        SubElement(author, "{http://wordpress.org/export/1.2/}author_display_name").text = profile.username
        SubElement(author, "{http://wordpress.org/export/1.2/}author_first_name").text = profile.full_name.split()[0] if profile.full_name else ""
        SubElement(author, "{http://wordpress.org/export/1.2/}author_last_name").text = profile.full_name.split()[-1] if profile.full_name and len(profile.full_name.split()) > 1 else ""

        # Add Default Category
        category = SubElement(channel, "{http://wordpress.org/export/1.2/}category")
        SubElement(category, "{http://wordpress.org/export/1.2/}term_id").text = "1"
        SubElement(category, "{http://wordpress.org/export/1.2/}category_nicename").text = "instagram"
        SubElement(category, "{http://wordpress.org/export/1.2/}category_parent").text = ""
        SubElement(category, "{http://wordpress.org/export/1.2/}cat_name").text = "Instagram"

        return rss, channel

    def download_media(self, post):
        try:
            if not os.path.exists(self.media_dest_folder):
                os.makedirs(self.media_dest_folder)
            if post.is_video:
                media_url = post.video_url
                extension = '.mp4'
            else:
                media_url = post.url
                extension = '.jpg'

            # Define a safe filename
            filename = f"{post.shortcode}{extension}"
            file_path = os.path.join(self.media_dest_folder, filename)

            # Download the media
            self.L.download_pic(file_path, media_url, post.date_utc)

            # Optionally, you can handle renaming or organizing files here

            self.logger.info(f"Downloaded media: {filename}")
            return filename  # Return the filename for XML reference

        except Exception as e:
            self.logger.error(f"Error downloading media for post {post.shortcode}: {e}")
            raise

    def process_posts(self, channel, profile):
        for post in profile.get_posts():
            try:
                # Create an <item> for each post
                item = SubElement(channel, "item")

                # Set the post title to the post date in YYYY-MM-DD format
                title = post.date.strftime('%Y-%m-%d')
                SubElement(item, "title").text = title

                # Add post link (Instagram post URL)
                post_url = f"https://www.instagram.com/p/{post.shortcode}/"
                SubElement(item, "link").text = post_url

                # Add publication date
                pub_date = post.date.strftime("%a, %d %b %Y %H:%M:%S +0000")
                SubElement(item, "pubDate").text = pub_date

                # Add DC Creator
                SubElement(item, "{http://purl.org/dc/elements/1.1/}creator").text = profile.username

                # Add GUID
                guid = SubElement(item, "guid", attrib={"isPermaLink": "false"})
                guid.text = post_url

                # Add description (left empty to avoid duplication)
                SubElement(item, "description").text = ""

                # Download media and get the filename
                media_filename = self.download_media(post)

                # Add post content (caption and image/video)
                if post.caption and post.is_video:
                    content = f"{post.caption}\n\n<video src='{self.media_base_url}/{media_filename}' controls></video>"
                elif post.caption:
                    content = f"{post.caption}\n\n<img src='{self.media_base_url}/{media_filename}' alt='Instagram Image' />"
                elif post.is_video:
                    content = f"<video src='{self.media_base_url}/{media_filename}' controls></video>"
                else:
                    content = f"<img src='{self.media_base_url}/{media_filename}' alt='Instagram Image' />"
                content_encoded = SubElement(item, "{http://purl.org/rss/1.0/modules/content/}encoded")
                content_encoded.text = content

                # Add excerpt (caption only)
                excerpt = post.caption if post.caption else ""
                excerpt_encoded = SubElement(item, "{http://wordpress.org/export/1.2/excerpt/}encoded")
                excerpt_encoded.text = excerpt

                # Add WordPress-specific post information
                SubElement(item, "{http://wordpress.org/export/1.2/}post_id").text = str(self.post_id_counter)
                post_date_str = post.date.strftime("%Y-%m-%d %H:%M:%S")
                SubElement(item, "{http://wordpress.org/export/1.2/}post_date").text = post_date_str
                SubElement(item, "{http://wordpress.org/export/1.2/}post_date_gmt").text = post_date_str
                SubElement(item, "{http://wordpress.org/export/1.2/}post_modified").text = post_date_str
                SubElement(item, "{http://wordpress.org/export/1.2/}post_modified_gmt").text = post_date_str
                SubElement(item, "{http://wordpress.org/export/1.2/}comment_status").text = "closed"
                SubElement(item, "{http://wordpress.org/export/1.2/}ping_status").text = "closed"
                SubElement(item, "{http://wordpress.org/export/1.2/}post_name").text = f"instagram-post-{self.post_id_counter}"
                SubElement(item, "{http://wordpress.org/export/1.2/}status").text = "publish"
                SubElement(item, "{http://wordpress.org/export/1.2/}post_parent").text = "0"
                SubElement(item, "{http://wordpress.org/export/1.2/}menu_order").text = "0"
                SubElement(item, "{http://wordpress.org/export/1.2/}post_type").text = "post"
                SubElement(item, "{http://wordpress.org/export/1.2/}post_password").text = ""
                SubElement(item, "{http://wordpress.org/export/1.2/}is_sticky").text = "0"

                # Add category
                category_elem = SubElement(item, "category", attrib={"domain": "category", "nicename": "instagram"})
                category_elem.text = "Instagram"

                # Add custom field for image or video URL
                custom_field = SubElement(item, "{http://wordpress.org/export/1.2/}postmeta")
                SubElement(custom_field, "{http://wordpress.org/export/1.2/}meta_key").text = "instagram_media_url"
                SubElement(custom_field, "{http://wordpress.org/export/1.2/}meta_value").text = f"{self.media_base_url}/{media_filename}"

                # Increment the post ID counter
                self.post_id_counter += 1

                self.logger.info(f"Processed post ID {self.post_id_counter - 1}: {title}")

            except Exception as e:
                self.logger.error(f"Error processing post {post.shortcode}: {e}")

    def generate_and_save_xml(self, rss):
        try:
            # Convert the XML tree to a byte string
            xml_bytes = tostring(rss, encoding='utf-8')

            # Parse the byte string with minidom for pretty printing
            parsed_xml = minidom.parseString(xml_bytes)
            pretty_xml_str = parsed_xml.toprettyxml(indent="  ")

            # Remove extra blank lines introduced by minidom
            pretty_xml_str = re.sub(r'\n\s*\n', '\n', pretty_xml_str)

            # Save the pretty-printed XML to a file
            with open(self.output_xml_file, "w", encoding="utf-8") as file:
                file.write(pretty_xml_str)

            self.logger.info(f"XML file '{self.output_xml_file}' generated successfully.")

        except Exception as e:
            self.logger.error(f"Error generating XML file: {e}")
            raise

    def export(self):
        # Fetch profile
        profile = self.fetch_profile()

        # Create XML structure
        rss, channel = self.create_wxr_structure(profile)

        # Process posts and download media
        self.process_posts(channel, profile)

        # Generate and save XML
        self.generate_and_save_xml(rss)

# ---------------------------- GUI Implementation ---------------------------- #

class ExporterGUI:
    def __init__(self, root):
        self.root = root
        self.root.title("Instagram to WordPress WXR Exporter")
        self.style = ttk.Style("flatly")  # You can choose other themes
        self.style.theme_use("flatly")
        self.create_widgets()

    def create_widgets(self):
        padding = 10

        # Frame for Instagram URL
        instagram_frame = ttk.Frame(self.root, padding=padding)
        instagram_frame.pack(fill=X)

        ttk.Label(instagram_frame, text="Instagram Username:").pack(side=LEFT, padx=(0, 5))
        self.username_var = tk.StringVar()
        self.username_entry = ttk.Entry(instagram_frame, textvariable=self.username_var, width=40)
        self.username_entry.pack(side=LEFT, fill=X, expand=True)

        # Frame for Media Destination Folder
        media_folder_frame = ttk.Frame(self.root, padding=padding)
        media_folder_frame.pack(fill=X)

        ttk.Label(media_folder_frame, text="Media Destination Folder:").pack(side=LEFT, padx=(0, 5))
        self.media_folder_var = tk.StringVar()
        self.media_folder_entry = ttk.Entry(media_folder_frame, textvariable=self.media_folder_var, width=40)
        self.media_folder_entry.pack(side=LEFT, fill=X, expand=True)
        ttk.Button(media_folder_frame, text="Browse", command=self.browse_media_folder).pack(side=LEFT, padx=(5,0))

        # Frame for Media Base URL
        media_url_frame = ttk.Frame(self.root, padding=padding)
        media_url_frame.pack(fill=X)

        ttk.Label(media_url_frame, text="Media Base URL:").pack(side=LEFT, padx=(0, 5))
        self.media_url_var = tk.StringVar()
        self.media_url_entry = ttk.Entry(media_url_frame, textvariable=self.media_url_var, width=40)
        self.media_url_entry.pack(side=LEFT, fill=X, expand=True)

        # Frame for Output XML File
        xml_file_frame = ttk.Frame(self.root, padding=padding)
        xml_file_frame.pack(fill=X)

        ttk.Label(xml_file_frame, text="Output XML File:").pack(side=LEFT, padx=(0, 5))
        self.xml_file_var = tk.StringVar(value="instagram_posts_wxr.xml")
        self.xml_file_entry = ttk.Entry(xml_file_frame, textvariable=self.xml_file_var, width=40)
        self.xml_file_entry.pack(side=LEFT, fill=X, expand=True)

        # Frame for Start Button
        button_frame = ttk.Frame(self.root, padding=padding)
        button_frame.pack(fill=X)

        self.start_button = ttk.Button(button_frame, text="Start Export", command=self.start_export)
        self.start_button.pack()

        # Frame for Log Output
        log_frame = ttk.Frame(self.root, padding=padding)
        log_frame.pack(fill=BOTH, expand=True)

        ttk.Label(log_frame, text="Log Output:").pack(anchor=NW)
        self.log_text = tk.Text(log_frame, height=15, state='disabled')
        self.log_text.pack(fill=BOTH, expand=True)

        # Redirect logger to the text widget
        self.setup_logging()

    def browse_media_folder(self):
        folder_selected = filedialog.askdirectory()
        if folder_selected:
            self.media_folder_var.set(folder_selected)

    def setup_logging(self):
        self.logger = logging.getLogger("GUIExporter")
        self.logger.setLevel(logging.INFO)

        # Create handler for logging to the text widget
        text_handler = TextHandler(self.log_text)
        text_handler.setLevel(logging.INFO)

        # Create formatter and add to handler
        formatter = logging.Formatter('%(levelname)s: %(message)s')
        text_handler.setFormatter(formatter)

        # Add handler to logger
        self.logger.addHandler(text_handler)

    def start_export(self):
        username = self.username_var.get().strip()
        media_folder = self.media_folder_var.get().strip()
        media_base_url = self.media_url_var.get().strip()
        output_xml = self.xml_file_var.get().strip()

        if not username:
            messagebox.showerror("Input Error", "Please enter the Instagram username.")
            return
        if not media_folder:
            messagebox.showerror("Input Error", "Please select the media destination folder.")
            return
        if not media_base_url:
            messagebox.showerror("Input Error", "Please enter the media base URL.")
            return
        if not output_xml:
            messagebox.showerror("Input Error", "Please specify the output XML file name.")
            return

        # Disable the start button to prevent multiple clicks
        self.start_button.config(state='disabled')

        # Start the export process in a separate thread to keep the GUI responsive
        threading.Thread(target=self.run_export, args=(username, media_folder, media_base_url, output_xml), daemon=True).start()

    def run_export(self, username, media_folder, media_base_url, output_xml):
        try:
            exporter = InstagramToWXRExporter(
                username=username,
                media_dest_folder=media_folder,
                media_base_url=media_base_url,
                output_xml_file=output_xml
            )

            # Optional: Add login credentials here if needed
            # exporter.login_if_needed('your_instagram_username', 'your_instagram_password')

            exporter.export()
            self.logger.info("Data extraction complete.")
            messagebox.showinfo("Success", f"Export completed successfully.\nCheck '{output_xml}'.")
        except Exception as e:
            self.logger.error(f"Export failed: {e}")
            messagebox.showerror("Export Failed", f"An error occurred during export:\n{e}")
        finally:
            self.start_button.config(state='normal')

class TextHandler(logging.Handler):
    """This class allows logging to a Tkinter Text widget."""

    def __init__(self, text_widget):
        super().__init__()
        self.text_widget = text_widget

    def emit(self, record):
        msg = self.format(record)
        def append():
            self.text_widget.configure(state='normal')
            self.text_widget.insert(tk.END, msg + '\n')
            self.text_widget.configure(state='disabled')
            self.text_widget.see(tk.END)
        self.text_widget.after(0, append)

# ---------------------------- Main Execution ---------------------------- #

def main():
    root = ttk.Window(themename="flatly")
    gui = ExporterGUI(root)
    root.geometry("700x500")
    root.mainloop()

if __name__ == "__main__":
    main()
