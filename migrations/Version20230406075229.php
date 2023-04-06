<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406075229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, artist_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, release_date VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, CONSTRAINT FK_39986E43B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_39986E43B7970CF8 ON album (artist_id)');
        $this->addSql('CREATE TABLE artist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE genre_artist (genre_id INTEGER NOT NULL, artist_id INTEGER NOT NULL, PRIMARY KEY(genre_id, artist_id), CONSTRAINT FK_EAEAA6A74296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EAEAA6A7B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EAEAA6A74296D31F ON genre_artist (genre_id)');
        $this->addSql('CREATE INDEX IDX_EAEAA6A7B7970CF8 ON genre_artist (artist_id)');
        $this->addSql('CREATE TABLE track (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, album_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, duration INTEGER NOT NULL, CONSTRAINT FK_D6E3F8A61137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A61137ABCF ON track (album_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE genre_artist');
        $this->addSql('DROP TABLE track');
        $this->addSql('DROP TABLE user');
    }
}
