<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223142055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medias_list_artist (medias_list_id INT NOT NULL, artist_id INT NOT NULL, PRIMARY KEY(medias_list_id, artist_id))');
        $this->addSql('CREATE INDEX IDX_8601BED52242A8F3 ON medias_list_artist (medias_list_id)');
        $this->addSql('CREATE INDEX IDX_8601BED5B7970CF8 ON medias_list_artist (artist_id)');
        $this->addSql('ALTER TABLE medias_list_artist ADD CONSTRAINT FK_8601BED52242A8F3 FOREIGN KEY (medias_list_id) REFERENCES medias_list (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medias_list_artist ADD CONSTRAINT FK_8601BED5B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE medias_list_artist DROP CONSTRAINT FK_8601BED52242A8F3');
        $this->addSql('ALTER TABLE medias_list_artist DROP CONSTRAINT FK_8601BED5B7970CF8');
        $this->addSql('DROP TABLE medias_list_artist');
    }
}
