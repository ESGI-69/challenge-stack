<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230208014756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_invite ADD artist_author_id INT NOT NULL');
        $this->addSql('ALTER TABLE event_invite ADD CONSTRAINT FK_F57B6785EAA19893 FOREIGN KEY (artist_author_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F57B6785EAA19893 ON event_invite (artist_author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event_invite DROP CONSTRAINT FK_F57B6785EAA19893');
        $this->addSql('DROP INDEX IDX_F57B6785EAA19893');
        $this->addSql('ALTER TABLE event_invite DROP artist_author_id');
    }
}
