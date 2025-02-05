import instaloader
from xml.etree.ElementTree import Element, SubElement, tostring, register_namespace
from xml.dom import minidom
import datetime

# Register namespaces to prevent duplicate xmlns attributes
register_namespace('excerpt', 'http://wordpress.org/export/1.2/excerpt/')
register_namespace('content', 'http://purl.org/rss/1.0/modules/content/')
register_namespace('wfw', 'http://wellformedweb.org/CommentAPI/')
register_namespace('dc', 'http://purl.org/dc/elements/1.1/')
register_namespace('wp', 'http://wordpress.org/export/1.2/')

# Initialize Instaloader
L = instaloader.Instaloader()

# Optionally, log in to Instagram if required
# L.login('your_username', 'your_password')

# Load the profile
profile = instaloader.Profile.from_username(L.context, "jvcarratala")

# Create the root element for the WXR XML without manually adding xmlns attributes
rss = Element("rss", {"version": "2.0"})

# Create the channel element
channel = SubElement(rss, "channel")

# Add basic channel information
SubElement(channel, "title").text = "Instagram Posts Export"
SubElement(channel, "link").text = "https://www.instagram.com/jvcarratala/"
SubElement(channel, "description").text = "Exported Instagram posts from jvcarratala"

# Add additional channel information
current_time = datetime.datetime.now(datetime.timezone.utc)
SubElement(channel, "pubDate").text = current_time.strftime("%a, %d %b %Y %H:%M:%S +0000")
SubElement(channel, "language").text = "en"  # Change to "es" if your site is in Spanish
SubElement(channel, "{http://wordpress.org/export/1.2/}wxr_version").text = "1.2"
SubElement(channel, "{http://wordpress.org/export/1.2/}base_site_url").text = "https://www.instagram.com/jvcarratala/"
SubElement(channel, "{http://wordpress.org/export/1.2/}base_blog_url").text = "https://www.instagram.com/jvcarratala/"

# Add generator information
SubElement(channel, "generator").text = "Custom Instagram to WXR Exporter"

# Add author information
author = SubElement(channel, "{http://wordpress.org/export/1.2/}author")
SubElement(author, "{http://wordpress.org/export/1.2/}author_id").text = "1"
SubElement(author, "{http://wordpress.org/export/1.2/}author_login").text = "jvcarratala"
SubElement(author, "{http://wordpress.org/export/1.2/}author_email").text = "info@josevicentecarratala.com"
SubElement(author, "{http://wordpress.org/export/1.2/}author_display_name").text = "jvcarratala"
SubElement(author, "{http://wordpress.org/export/1.2/}author_first_name").text = ""
SubElement(author, "{http://wordpress.org/export/1.2/}author_last_name").text = ""

# Add default category
category = SubElement(channel, "{http://wordpress.org/export/1.2/}category")
SubElement(category, "{http://wordpress.org/export/1.2/}term_id").text = "1"
SubElement(category, "{http://wordpress.org/export/1.2/}category_nicename").text = "instagram"
SubElement(category, "{http://wordpress.org/export/1.2/}category_parent").text = ""
SubElement(category, "{http://wordpress.org/export/1.2/}cat_name").text = "Instagram"

# Initialize a post ID counter to ensure unique IDs
post_id_counter = 1000  # Starting from 1000 to avoid conflicts

# Iterate over the posts
for post in profile.get_posts():
    # Create an item for each post
    item = SubElement(channel, "item")

    # Add post title (using the caption or a default title)
    title = post.caption if post.caption else f"Instagram Post from {post.date.strftime('%Y-%m-%d')}"
    SubElement(item, "title").text = title

    # Add post link (Instagram post URL)
    SubElement(item, "link").text = f"https://www.instagram.com/p/{post.shortcode}/"

    # Add publication date
    SubElement(item, "pubDate").text = post.date.strftime("%a, %d %b %Y %H:%M:%S +0000")

    # Add DC Creator
    SubElement(item, "{http://purl.org/dc/elements/1.1/}creator").text = "jvcarratala"

    # Add GUID
    guid = SubElement(item, "guid", attrib={"isPermaLink": "false"})
    guid.text = f"https://www.instagram.com/p/{post.shortcode}/"

    # Add description (optional: using caption)
    SubElement(item, "description").text = post.caption if post.caption else ""

    # Add post content (caption and image URL)
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
    excerpt_encoded = SubElement(item, "{http://wordpress.org/export/1.2/excerpt/}encoded")
    excerpt_encoded.text = post.caption if post.caption else ""

    # Add WordPress-specific post information
    SubElement(item, "{http://wordpress.org/export/1.2/}post_id").text = str(post_id_counter)
    SubElement(item, "{http://wordpress.org/export/1.2/}post_date").text = post.date.strftime("%Y-%m-%d %H:%M:%S")
    SubElement(item, "{http://wordpress.org/export/1.2/}post_date_gmt").text = post.date.strftime("%Y-%m-%d %H:%M:%S")
    SubElement(item, "{http://wordpress.org/export/1.2/}post_modified").text = post.date.strftime("%Y-%m-%d %H:%M:%S")
    SubElement(item, "{http://wordpress.org/export/1.2/}post_modified_gmt").text = post.date.strftime("%Y-%m-%d %H:%M:%S")
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

# Convert the XML tree to a pretty-printed string
xml_bytes = tostring(rss, encoding='utf-8')
xml_str = minidom.parseString(xml_bytes).toprettyxml(indent="  ")

# Optionally, remove extra blank lines introduced by minidom
import re
xml_str = re.sub(r'\n\s*\n', '\n', xml_str)

# Save the XML to a file
with open("instagram_posts_wxr.xml", "w", encoding="utf-8") as file:
    file.write(xml_str)

print("Data extraction complete. Check 'instagram_posts_wxr.xml'.")
