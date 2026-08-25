Add-Type -AssemblyName System.Drawing

$inputPath = "c:\xampp\htdocs\idein\img\logo.jpg"
$outputPath = "c:\xampp\htdocs\idein\img\logo.png"
$outputPathSource = "c:\idein\img\logo.png"

# Load the image
$img = [System.Drawing.Image]::FromFile($inputPath)
$bmp = New-Object System.Drawing.Bitmap($img.Width, $img.Height, [System.Drawing.Imaging.PixelFormat]::Format32bppArgb)

# Draw original onto new bitmap
$g = [System.Drawing.Graphics]::FromImage($bmp)
$g.DrawImage($img, 0, 0, $img.Width, $img.Height)
$g.Dispose()
$img.Dispose()

# Threshold for "white-ish" pixels
$threshold = 230

for ($x = 0; $x -lt $bmp.Width; $x++) {
    for ($y = 0; $y -lt $bmp.Height; $y++) {
        $pixel = $bmp.GetPixel($x, $y)
        if ($pixel.R -gt $threshold -and $pixel.G -gt $threshold -and $pixel.B -gt $threshold) {
            $bmp.SetPixel($x, $y, [System.Drawing.Color]::FromArgb(0, 255, 255, 255))
        }
        # Smooth edges: semi-transparent for near-white pixels
        elseif ($pixel.R -gt 200 -and $pixel.G -gt 200 -and $pixel.B -gt 200) {
            $avg = [int](($pixel.R + $pixel.G + $pixel.B) / 3)
            $alpha = [Math]::Max(0, [Math]::Min(255, [int]((255 - $avg) * (255.0 / (255 - 200)))))
            $bmp.SetPixel($x, $y, [System.Drawing.Color]::FromArgb($alpha, $pixel.R, $pixel.G, $pixel.B))
        }
    }
}

# Save as PNG (supports transparency)
$bmp.Save($outputPath, [System.Drawing.Imaging.ImageFormat]::Png)
$bmp.Save($outputPathSource, [System.Drawing.Imaging.ImageFormat]::Png)
$bmp.Dispose()

Write-Host "Logo transparente guardado en $outputPath"
