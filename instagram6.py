import instaloader
from xml.etree.ElementTree import Element, SubElement, tostring, register_namespace
from xml.dom import minidom
import datetime
import re
import logging

# ---------------------------- Configuration ---------------------------- #

# Instagram profile to export
INSTAGRAM_USERNAME = "jvcarratala"

# Output XML file name
OUTPUT_XML_FILE = "instagram_posts_wxr.xml"

# Starting post ID (ensure it's unique to avoid conflicts with existing WordPress posts)
START_POST_ID = 1000

# Language code (e.g., "en" for English, "es" for Spanish)
LANGUAGE_CODE = "en"

# ---------------------------- Logging Setup ---------------------------- #

# Configure logging
logging.basicConfig(
    level=logging.INFO,
    format='%(levelname)s: %(message)s'
)

# ---------------------------- Namespace Registration ---------------------------- #

# Register namespaces to prevent duplicate xmlns attributes
register_namespace('excerpt', 'http://wordpress.org/export/1.2/excerpt/')
register_namespace('content', 'http://purl.org/rss/1.0/modules/content/')
register_namespace('wfw', 'http://wellformedweb.org/CommentAPI/')
register_namespace('dc', 'http://purl.org/dc/elements/1.1/')
register_namespace('wp', 'http://wordpress.org/export/1.2/')

# ---------------------------- Initialize Instaloader ---------------------------- #

# Initialize Instaloader
L = instaloader.Instaloader()

# Optional: Log in to Instagram if the profile is private or to access additional data
# Uncomment the following lines and replace with your credentials if needed
# try:
#     L.login('your_username', 'your_password')
#     logging.info("Logged in to Instagram successfully.")
# except Exception as e:
#     logging.error(f"Failed to log in to Instagram: {e}")
#     exit(1)

# ---------------------------- Fetch Instagram Profile ---------------------------- #

try:
    profile = instaloader.Profile.from_username(L.context, INSTAGRAM_USERNAME)
    logging.info(f"Successfully loaded profile: {profile.username}")
except Exception as e:
    logging.error(f"Error loading profile '{INSTAGRAM_USERNAME}': {e}")
    exit(1)

# ---------------------------- Create WXR XML Structure ---------------------------- #

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
SubElement(channel, "language").text = LANGUAGE_CODE
SubElement(channel, "{http://wordpress.org/export/1.2/}wxr_version").text = "1.2"
SubElement(channel, "{http://wordpress.org/export/1.2/}base_site_url").text = f"https://www.instagram.com/{profile.username}/"
SubElement(channel, "{http://wordpress.org/export/1.2/}base_blog_url").text = f"https://www.instagram.com/{profile.username}/"

# Add generator information
SubElement(channel, "generator").text = "Custom Instagram to WXR Exporter"

# ---------------------------- Add Author Information ---------------------------- #

author = SubElement(channel, "{http://wordpress.org/export/1.2/}author")
SubElement(author, "{http://wordpress.org/export/1.2/}author_id").text = "1"
SubElement(author, "{http://wordpress.org/export/1.2/}author_login").text = profile.username
SubElement(author, "{http://wordpress.org/export/1.2/}author_email").text = "info@example.com"  # Replace with actual email
SubElement(author, "{http://wordpress.org/export/1.2/}author_display_name").text = profile.username
SubElement(author, "{http://wordpress.org/export/1.2/}author_first_name").text = profile.full_name.split()[0] if profile.full_name else ""
SubElement(author, "{http://wordpress.org/export/1.2/}author_last_name").text = profile.full_name.split()[-1] if profile.full_name and len(profile.full_name.split()) > 1 else ""

# ---------------------------- Add Default Category ---------------------------- #

category = SubElement(channel, "{http://wordpress.org/export/1.2/}category")
SubElement(category, "{http://wordpress.org/export/1.2/}term_id").text = "1"
SubElement(category, "{http://wordpress.org/export/1.2/}category_nicename").text = "instagram"
SubElement(category, "{http://wordpress.org/export/1.2/}category_parent").text = ""
SubElement(category, "{http://wordpress.org/export/1.2/}cat_name").text = "Instagram"

# ---------------------------- Initialize Post ID Counter ---------------------------- #

post_id_counter = START_POST_ID

# ---------------------------- Iterate Over Instagram Posts ---------------------------- #

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

        # Add post content (caption and image/video)
        if post.caption and post.is_video:
            content = f"{post.caption}\n\n<video src='{post.video_url}' controls></video>"
        elif post.caption:
            content = f"{post.caption}\n\n<img src='{post.url}' alt='Instagram Image' />"
        elif post.is_video:
            content = f"<video src='{post.video_url}' controls></video>"
        else:
            content = f"<img src='{post.url}' alt='Instagram Image' />"
        content_encoded = SubElement(item, "{http://purl.org/rss/1.0/modules/content/}encoded")
        content_encoded.text = content

        # Add excerpt (caption only)
        excerpt = post.caption if post.caption else ""
        excerpt_encoded = SubElement(item, "{http://wordpress.org/export/1.2/excerpt/}encoded")
        excerpt_encoded.text = excerpt

        # Add WordPress-specific post information
        SubElement(item, "{http://wordpress.org/export/1.2/}post_id").text = str(post_id_counter)
        post_date_str = post.date.strftime("%Y-%m-%d %H:%M:%S")
        SubElement(item, "{http://wordpress.org/export/1.2/}post_date").text = post_date_str
        SubElement(item, "{http://wordpress.org/export/1.2/}post_date_gmt").text = post_date_str
        SubElement(item, "{http://wordpress.org/export/1.2/}post_modified").text = post_date_str
        SubElement(item, "{http://wordpress.org/export/1.2/}post_modified_gmt").text = post_date_str
        SubElement(item, "{http://wordpress.org/export/1.2/}comment_status").text = "closed"
        SubElement(item, "{http://wordpress.org/export/1.2/}ping_status").text = "closed"
        SubElement(item, "{http://wordpress.org/export/1.2/}post_name").text = f"instagram-post-{post_id_counter}"
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
        image_url = post.video_url if post.is_video else post.url
        custom_field = SubElement(item, "{http://wordpress.org/export/1.2/}postmeta")
        SubElement(custom_field, "{http://wordpress.org/export/1.2/}meta_key").text = "instagram_image_url"
        SubElement(custom_field, "{http://wordpress.org/export/1.2/}meta_value").text = image_url

        # Increment the post ID counter
        post_id_counter += 1

        logging.info(f"Processed post ID {post_id_counter - 1}: {title}")

    except Exception as e:
        logging.error(f"Error processing post {post.shortcode}: {e}")

# ---------------------------- Generate and Save XML ---------------------------- #

try:
    # Convert the XML tree to a byte string
    xml_bytes = tostring(rss, encoding='utf-8')

    # Parse the byte string with minidom for pretty printing
    parsed_xml = minidom.parseString(xml_bytes)
    pretty_xml_str = parsed_xml.toprettyxml(indent="  ")

    # Remove extra blank lines introduced by minidom
    pretty_xml_str = re.sub(r'\n\s*\n', '\n', pretty_xml_str)

    # Save the pretty-printed XML to a file
    with open(OUTPUT_XML_FILE, "w", encoding="utf-8") as file:
        file.write(pretty_xml_str)

    logging.info(f"XML file '{OUTPUT_XML_FILE}' generated successfully.")

except Exception as e:
    logging.error(f"Error generating XML file: {e}")
    exit(1)

print(f"Data extraction complete. Check '{OUTPUT_XML_FILE}'.")
