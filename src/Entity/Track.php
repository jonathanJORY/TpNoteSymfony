<?php

namespace App\Entity;

use App\Repository\TrackRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrackRepository::class)]
class Track
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'tracks')]
    private ?Album $album = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 255, nullable: false, options: ["default" => ""])]
    private ?string $spotifyUri = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->album->getImage();
    }

    public function getSpotifyUri(): ?string
    {
        return $this->spotifyUri;
    }

    public function setSpotifyUri(?string $spotifyUri): self
    {
        $this->spotifyUri = $spotifyUri;

        return $this;
    }


    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDurationMinuteString(): ?String
    {
        $totalSeconds = $this->duration / 1000;
        $minutes = floor($totalSeconds / 60);
        $seconds = $totalSeconds % 60;
    
        return $minutes . "min" . $seconds . "s";
    }
}
