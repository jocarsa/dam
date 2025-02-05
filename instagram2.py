import instaloader
import csv

# Initialize Instaloader
L = instaloader.Instaloader()

# Load the profile
profile = instaloader.Profile.from_username(L.context, "jvcarratala")

# Open a CSV file to save the data
with open('instagram_posts.csv', mode='w', newline='', encoding='utf-8') as file:
    writer = csv.writer(file)
    writer.writerow(["Fecha", "Texto", "Image URL"])  # Add "Image URL" column

    # Iterate over the posts
    for post in profile.get_posts():
        # Get the image URL (or the first image URL if it's a carousel post)
        if post.is_video:
            image_url = post.video_url  # For video posts
        else:
            image_url = post.url  # For image posts

        # Write the data to the CSV file
        writer.writerow([post.date, post.caption, image_url])

print("Data extraction complete. Check 'instagram_posts.csv'.")
