<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201092411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist_user (artist_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(artist_id, user_id))');
        $this->addSql('CREATE INDEX IDX_312D50D6B7970CF8 ON artist_user (artist_id)');
        $this->addSql('CREATE INDEX IDX_312D50D6A76ED395 ON artist_user (user_id)');
        $this->addSql('ALTER TABLE artist_user ADD CONSTRAINT FK_312D50D6B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artist_user ADD CONSTRAINT FK_312D50D6A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE artist_user DROP CONSTRAINT FK_312D50D6B7970CF8');
        $this->addSql('ALTER TABLE artist_user DROP CONSTRAINT FK_312D50D6A76ED395');
        $this->addSql('DROP TABLE artist_user');
    }
}
