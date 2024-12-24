<?php

namespace App\Utils;

use Storage;

class FileUtils
{
    /**
     * Gera um nome único para o arquivo de imagem.
     *
     * @param string $userName
     * @param string $extension
     * @return string
     */
    public static function generateFileName(string $userName, string $extension): string
    {
        return 'perfil_' . preg_replace('/\s+/', '_', $userName) . '_' . time() . '.' . $extension;
    }

    /**
     * Remove a imagem antiga do armazenamento, se existir.
     *
     * @param string|null $fileName
     * @return void
     */
    public static function deleteOldProfileImage(?string $fileName): void
    {
        if ($fileName && Storage::disk('public')->exists('profile_images/' . $fileName)) {
            Storage::disk('public')->delete('profile_images/' . $fileName);
        }
    }
}