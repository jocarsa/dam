import instaloader

# Inicializa Instaloader
L = instaloader.Instaloader()

# Carga el perfil
profile = instaloader.Profile.from_username(L.context, "jvcarratala")

# Abre un archivo Excel para guardar los datos
import csv
with open('instagram_posts.csv', mode='w', newline='', encoding='utf-8') as file:
    writer = csv.writer(file)
    writer.writerow(["Fecha", "Texto"])

    # Itera sobre las publicaciones
    for post in profile.get_posts():
        writer.writerow([post.date, post.caption])
