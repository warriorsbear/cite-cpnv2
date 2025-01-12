<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ExifHandler
{
    private $exifData;

    public function extractExif(UploadedFile $file): array
    {
        try {
            // Lecture des données EXIF
            $this->exifData = @exif_read_data($file->getPathname(), 'ANY_TAG', true);

            // Log pour debug
            Log::info('Données EXIF brutes:', ['exif' => $this->exifData]);

            if ($this->exifData === false) {
                Log::warning('Aucune donnée EXIF trouvée pour le fichier: ' . $file->getClientOriginalName());
                return $this->getEmptyExifData();
            }

            $exifFormatted = [
                'exif1' => $this->getCamera(),        // Boitier
                'exif2' => $this->getLens(),          // Objectif
                'exif3' => $this->getFocalLength(),   // Distance focale
                'exif4' => $this->getAperture(),      // Ouverture
                'exif5' => $this->getShutterSpeed(),  // Vitesse d'obturation
                'exif6' => $this->getISO()            // ISO
            ];

            // Log des données formatées
            Log::info('Données EXIF formatées:', $exifFormatted);

            return $exifFormatted;
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'extraction EXIF: ' . $e->getMessage());
            return $this->getEmptyExifData();
        }
    }

    private function getCamera(): ?string
    {
        $make = $this->exifData['IFD0']['Make'] ?? null;
        $model = $this->exifData['IFD0']['Model'] ?? null;
        return $make && $model ? "{$make} {$model}" : null;
    }

    private function getLens(): ?string
    {
        $lens = $this->exifData['EXIF']['LensModel'] ??
            $this->exifData['EXIF']['UndefinedTag:0xA434'] ?? null;
        return $lens ? "{$lens}" : null;
    }

    private function getFocalLength(): ?string
    {
        $focal = $this->exifData['EXIF']['FocalLength'] ?? null;
        if ($focal) {
            if (is_string($focal)) {
                $parts = explode('/', $focal);
                if (count($parts) == 2 && $parts[1] != 0) {
                    $focal = $parts[0] / $parts[1];
                }
            }
            return "{$focal}mm";
        }
        return null;
    }

    private function getAperture(): ?string
    {
        $aperture = $this->exifData['EXIF']['FNumber'] ?? null;
        if ($aperture) {
            if (is_string($aperture)) {
                $parts = explode('/', $aperture);
                if (count($parts) == 2 && $parts[1] != 0) {
                    $aperture = $parts[0] / $parts[1];
                }
            }
            return "f/{$aperture}";
        }
        return null;
    }

    private function getShutterSpeed(): ?string
    {
        $speed = $this->exifData['EXIF']['ExposureTime'] ?? null;
        if ($speed) {
            if (is_string($speed)) {
                $parts = explode('/', $speed);
                if (count($parts) == 2 && $parts[1] != 0) {
                    $speed = "1/{$parts[1]}";
                }
            }
            return "{$speed}s";
        }
        return null;
    }

    private function getISO(): ?string
    {
        $iso = $this->exifData['EXIF']['ISOSpeedRatings'] ?? null;
        return $iso ? "{$iso}" : null;
    }

    private function getEmptyExifData(): array
    {
        return [
            'exif1' => null,
            'exif2' => null,
            'exif3' => null,
            'exif4' => null,
            'exif5' => null,
            'exif6' => null
        ];
    }
}
