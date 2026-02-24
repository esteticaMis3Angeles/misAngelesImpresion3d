from PIL import Image
import os
from pathlib import Path

# Image optimization script
img_folder = r"c:\Users\Dell\Documents\BR\Proyectos\Brayam1993_Git_Repo\restaurante-website\img"
gallery_folder = os.path.join(img_folder, "galeria")

def optimize_image(file_path, quality=75, max_width=1920):
    """Optimize a single image by resizing and compressing"""
    try:
        img = Image.open(file_path)
        original_size = os.path.getsize(file_path) / 1024 / 1024  # MB
        
        # Resize if wider than max_width
        if img.width > max_width:
            ratio = max_width / img.width
            new_height = int(img.height * ratio)
            img = img.resize((max_width, new_height), Image.Resampling.LANCZOS)
        
        # Save with compression
        if file_path.lower().endswith('.jpg') or file_path.lower().endswith('.jpeg'):
            img.save(file_path, 'JPEG', quality=quality, optimize=True)
        elif file_path.lower().endswith('.png'):
            img.save(file_path, 'PNG', optimize=True)
        
        new_size = os.path.getsize(file_path) / 1024 / 1024  # MB
        reduction = ((original_size - new_size) / original_size) * 100
        
        print(f"✓ {os.path.basename(file_path)}: {original_size:.2f}MB → {new_size:.2f}MB ({reduction:.1f}% reduction)")
        return True
    except Exception as e:
        print(f"✗ Error processing {file_path}: {e}")
        return False

# Process main img folder
print("=" * 70)
print("OPTIMIZING MAIN IMAGES")
print("=" * 70)

if os.path.exists(img_folder):
    for file in os.listdir(img_folder):
        if file.lower().endswith(('.jpg', '.jpeg', '.png')):
            file_path = os.path.join(img_folder, file)
            optimize_image(file_path)

# Process gallery subfolder
print("\n" + "=" * 70)
print("OPTIMIZING GALLERY IMAGES")
print("=" * 70)

if os.path.exists(gallery_folder):
    for file in os.listdir(gallery_folder):
        if file.lower().endswith(('.jpg', '.jpeg', '.png')):
            file_path = os.path.join(gallery_folder, file)
            optimize_image(file_path)

print("\n" + "=" * 70)
print("OPTIMIZATION COMPLETE!")
print("=" * 70)
