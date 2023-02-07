<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207134320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE event_invite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE event_invite (id INT NOT NULL, id_event_id INT DEFAULT NULL, id_artist_id INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F57B6785212C041E ON event_invite (id_event_id)');
        $this->addSql('CREATE INDEX IDX_F57B678537A2B0DF ON event_invite (id_artist_id)');
        $this->addSql('ALTER TABLE event_invite ADD CONSTRAINT FK_F57B6785212C041E FOREIGN KEY (id_event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_invite ADD CONSTRAINT FK_F57B678537A2B0DF FOREIGN KEY (id_artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE event_invite_id_seq CASCADE');
        $this->addSql('ALTER TABLE event_invite DROP CONSTRAINT FK_F57B6785212C041E');
        $this->addSql('ALTER TABLE event_invite DROP CONSTRAINT FK_F57B678537A2B0DF');
        $this->addSql('DROP TABLE event_invite');
    }
}
