import instaloader
from xml.etree.ElementTree import Element, SubElement, tostring
from xml.dom import minidom

# Initialize Instaloader
L = instaloader.Instaloader()

# Load the profile
profile = instaloader.Profile.from_username(L.context, "jvcarratala")

# Create the root element for the WXR XML
rss = Element(
    "rss",
    {
        "version": "2.0",
        "xmlns:excerpt": "http://wordpress.org/export/1.2/excerpt/",
        "xmlns:content": "http://purl.org/rss/1.0/modules/content/",
        "xmlns:wp": "http://wordpress.org/export/1.2/",
    },
)

# Create the channel element
channel = SubElement(rss, "channel")

# Add basic channel information
SubElement(channel, "title").text = "Instagram Posts Export"
SubElement(channel, "link").text = "https://www.instagram.com/jvcarratala/"
SubElement(channel, "description").text = "Exported Instagram posts from jvcarratala"

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

    # Add post content (caption and image URL)
    content = f"{post.caption}\n\n<img src='{post.url}' alt='Instagram Image' />"
    content_encoded = SubElement(item, "{http://purl.org/rss/1.0/modules/content/}encoded")
    content_encoded.text = content

    # Add excerpt (caption only)
    excerpt_encoded = SubElement(item, "{http://wordpress.org/export/1.2/excerpt/}encoded")
    excerpt_encoded.text = post.caption if post.caption else ""

    # Add post type (default to 'post')
    post_type = SubElement(item, "{http://wordpress.org/export/1.2/}post_type")
    post_type.text = "post"

    # Add post date in WordPress format
    post_date = SubElement(item, "{http://wordpress.org/export/1.2/}post_date")
    post_date.text = post.date.strftime("%Y-%m-%d %H:%M:%S")

    # Add image URL as a custom field
    image_url = post.video_url if post.is_video else post.url
    custom_field = SubElement(item, "{http://wordpress.org/export/1.2/}postmeta")
    SubElement(custom_field, "{http://wordpress.org/export/1.2/}meta_key").text = "instagram_image_url"
    SubElement(custom_field, "{http://wordpress.org/export/1.2/}meta_value").text = image_url

# Convert the XML tree to a pretty-printed string
xml_str = minidom.parseString(tostring(rss)).toprettyxml(indent="  ")

# Save the XML to a file
with open("instagram_posts_wxr.xml", "w", encoding="utf-8") as file:
    file.write(xml_str)

print("Data extraction complete. Check 'instagram_posts_wxr.xml'.")
