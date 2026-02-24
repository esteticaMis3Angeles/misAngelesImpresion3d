# Image Optimization Script using PowerShell and .NET
Add-Type -AssemblyName System.Drawing

function Optimize-Image {
    param(
        [string]$FilePath,
        [int]$Quality = 75,
        [int]$MaxWidth = 1920
    )
    
    try {
        $originalSize = (Get-Item $FilePath).Length / 1MB
        $image = [System.Drawing.Image]::FromFile($FilePath)
        
        # Calculate new dimensions
        $newWidth = [Math]::Min($image.Width, $MaxWidth)
        $ratio = $newWidth / $image.Width
        $newHeight = [int]($image.Height * $ratio)
        
        # Create resized bitmap
        $bitmap = New-Object System.Drawing.Bitmap($newWidth, $newHeight)
        $graphics = [System.Drawing.Graphics]::FromImage($bitmap)
        $graphics.DrawImage($image, 0, 0, $newWidth, $newHeight)
        
        # Save with compression
        $encoder = [System.Drawing.Imaging.ImageCodecInfo]::GetImageEncoders() | 
            Where-Object { $_.MimeType -eq 'image/jpeg' }
        $encoderParams = New-Object System.Drawing.Imaging.EncoderParameters(1)
        $encoderParams.Param[0] = New-Object System.Drawing.Imaging.EncoderParameter(
            [System.Drawing.Imaging.Encoder]::Quality, $Quality)
        
        $bitmap.Save($FilePath, $encoder, $encoderParams)
        
        # Cleanup
        $graphics.Dispose()
        $bitmap.Dispose()
        $image.Dispose()
        
        $newSize = (Get-Item $FilePath).Length / 1MB
        $reduction = (($originalSize - $newSize) / $originalSize) * 100
        
        Write-Host "✓ $(Split-Path $FilePath -Leaf): $($originalSize)MB → $($newSize)MB ($($reduction)% reduction)"
    }
    catch {
        Write-Host "✗ Error processing $(Split-Path $FilePath -Leaf): $_"
    }
}

# Main execution
$imgFolder = "c:\Users\Dell\Documents\BR\Proyectos\Brayam1993_Git_Repo\restaurante-website\img"
$galleryFolder = Join-Path $imgFolder "galeria"

Write-Host ("=" * 70)
Write-Host "OPTIMIZING MAIN IMAGES"
Write-Host ("=" * 70)

Get-ChildItem -Path $imgFolder -Filter "*.jpg" -File | ForEach-Object {
    Optimize-Image -FilePath $_.FullName
}

Write-Host ""
Write-Host ("=" * 70)
Write-Host "OPTIMIZING GALLERY IMAGES"
Write-Host ("=" * 70)

Get-ChildItem -Path $galleryFolder -Filter "*.jpg" -File | ForEach-Object {
    Optimize-Image -FilePath $_.FullName
}

Write-Host ""
Write-Host ("=" * 70)
Write-Host "OPTIMIZATION COMPLETE!"
Write-Host ("=" * 70)
