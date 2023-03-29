<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329143428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genre_artist (genre_id INTEGER NOT NULL, artist_id INTEGER NOT NULL, PRIMARY KEY(genre_id, artist_id), CONSTRAINT FK_EAEAA6A74296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EAEAA6A7B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_EAEAA6A74296D31F ON genre_artist (genre_id)');
        $this->addSql('CREATE INDEX IDX_EAEAA6A7B7970CF8 ON genre_artist (artist_id)');
        $this->addSql('DROP TABLE genre_album');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genre_album (genre_id INTEGER NOT NULL, album_id INTEGER NOT NULL, PRIMARY KEY(genre_id, album_id), CONSTRAINT FK_849E71864296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_849E71861137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_849E71861137ABCF ON genre_album (album_id)');
        $this->addSql('CREATE INDEX IDX_849E71864296D31F ON genre_album (genre_id)');
        $this->addSql('DROP TABLE genre_artist');
    }
}
