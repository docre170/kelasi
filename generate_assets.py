from PIL import Image, ImageDraw, FontFile

# Créer un logo simple
img = Image.new('RGB', (200, 60), color='#0056b3')
d = ImageDraw.Draw(img)
d.text((15, 20), "KELASI", fill=(255, 255, 255))
img.save('/home/ubuntu/kelasi/kelasi/assets/images/logo.png')

# Créer un favicon simple
favicon = Image.new('RGB', (32, 32), color='#0056b3')
df = ImageDraw.Draw(favicon)
df.text((6, 8), "K", fill=(255, 255, 255))
favicon.save('/home/ubuntu/kelasi/kelasi/assets/images/favicon.ico')

print("Assets generated successfully.")
