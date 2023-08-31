<?php

namespace App\Enums;

enum LinkType: string
{
    case WEBSITE = 'website';
    case TWITTER = 'twitter';
    case FACEBOOK = 'facebook';
    case LINKEDIN = 'linkedin';
    case TELEGRAM = 'telegram';
    case INSTAGRAM = 'instagram';
    case TIKTOK = 'tiktok';

    public function fullUrl($username)
    {
        return match ($this) {
            LinkType::TIKTOK => "https://www.tiktok.com/@" . $username,
            LinkType::TWITTER => 'https://twitter.com/' . $username,
            LinkType::FACEBOOK => 'https://facebook.com/' . $username,
            LinkType::LINKEDIN => 'https://linkedin.com/' . $username,
            LinkType::TELEGRAM => 'https://t.me/' . $username,
            LinkType::INSTAGRAM => 'https://instagram.com/' . $username,
            LinkType::WEBSITE => $username,
        };
    }
}
