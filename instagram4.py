import instaloader
from xml.etree.ElementTree import Element, SubElement, tostring
from xml.dom import minidom
import datetime

# Initialize Instaloader
L = instaloader.Instaloader()

# Load the profile
profile = instaloader.Profile.from_username(L.context, "jvcarratala")

# Create the root element for the WXR XML with all necessary namespaces
rss = Element(
    "rss",
    {
        "version": "2.0",
        "xmlns:excerpt": "http://wordpress.org/export/1.2/excerpt/",
        "xmlns:content": "http://purl.org/rss/1.0/modules/content/",
        "xmlns:wfw": "http://wellformedweb.org/CommentAPI/",
        "xmlns:dc": "http://purl.org/dc/elements/1.1/",
        "xmlns:wp": "http://wordpress.org/export/1.2/",
    },
)

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
SubElement(channel, "wp:wxr_version").text = "1.2"
SubElement(channel, "wp:base_site_url").text = "https://www.instagram.com/jvcarratala/"
SubElement(channel, "wp:base_blog_url").text = "https://www.instagram.com/jvcarratala/"

# Add generator information
SubElement(channel, "generator").text = "Custom Instagram to WXR Exporter"

# Add author information
author = SubElement(channel, "wp:author")
SubElement(author, "wp:author_id").text = "1"
SubElement(author, "wp:author_login").text = "jvcarratala"
SubElement(author, "wp:author_email").text = "info@josevicentecarratala.com"
SubElement(author, "wp:author_display_name").text = "jvcarratala"
SubElement(author, "wp:author_first_name").text = ""
SubElement(author, "wp:author_last_name").text = ""

# Add default category
category = SubElement(channel, "wp:category")
SubElement(category, "wp:term_id").text = "1"
SubElement(category, "wp:category_nicename").text = "instagram"
SubElement(category, "wp:category_parent").text = ""
SubElement(category, "wp:cat_name").text = "Instagram"

# Initialize a post ID counter to ensure unique IDs
post_id_counter = 1000  # Starting from 1000 to avoid conflicts

# Iterate over the posts
for post in profile.get_posts():
    # Create an item for each post
    item = SubElement(channel, "item")

    # Add post title (using the caption or a default title)
    title = post.caption if post.caption else f"Instagram Post from {post.date}"
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
    content = f"{post.caption}\n\n<img src='{post.url}' alt='Instagram Image' />" if post.caption else f"<img src='{post.url}' alt='Instagram Image' />"
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

    # Add custom field for image URL
    image_url = post.video_url if post.is_video else post.url
    custom_field = SubElement(item, "{http://wordpress.org/export/1.2/}postmeta")
    SubElement(custom_field, "{http://wordpress.org/export/1.2/}meta_key").text = "instagram_image_url"
    SubElement(custom_field, "{http://wordpress.org/export/1.2/}meta_value").text = image_url

    # Increment the post ID counter
    post_id_counter += 1

# Convert the XML tree to a pretty-printed string
xml_bytes = tostring(rss, encoding='utf-8')
xml_str = minidom.parseString(xml_bytes).toprettyxml(indent="  ")

# Save the XML to a file
with open("instagram_posts_wxr.xml", "w", encoding="utf-8") as file:
    file.write(xml_str)

print("Data extraction complete. Check 'instagram_posts_wxr.xml'.")
