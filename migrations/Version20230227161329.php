<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227161329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artist DROP CONSTRAINT FK_1599687783E3463');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT FK_1599687783E3463 FOREIGN KEY (manager_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C79F37AE5');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C9514AA5C');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9514AA5C FOREIGN KEY (id_post_id) REFERENCES post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA733F585D2');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7EAA19893');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA733F585D2 FOREIGN KEY (id_concerthall_id) REFERENCES concert_hall (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7EAA19893 FOREIGN KEY (artist_author_id) REFERENCES artist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_invite DROP CONSTRAINT FK_F57B678537A2B0DF');
        $this->addSql('ALTER TABLE event_invite DROP CONSTRAINT FK_F57B6785EAA19893');
        $this->addSql('ALTER TABLE event_invite ADD CONSTRAINT FK_F57B678537A2B0DF FOREIGN KEY (id_artist_id) REFERENCES artist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_invite ADD CONSTRAINT FK_F57B6785EAA19893 FOREIGN KEY (artist_author_id) REFERENCES artist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D79F37AE5');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D212C041E');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D37A2B0DF');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D79F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D212C041E FOREIGN KEY (id_event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D37A2B0DF FOREIGN KEY (id_artist_id) REFERENCES artist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526c79f37ae5');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526c9514aa5c');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526c79f37ae5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526c9514aa5c FOREIGN KEY (id_post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_invite DROP CONSTRAINT fk_f57b678537a2b0df');
        $this->addSql('ALTER TABLE event_invite DROP CONSTRAINT fk_f57b6785eaa19893');
        $this->addSql('ALTER TABLE event_invite ADD CONSTRAINT fk_f57b678537a2b0df FOREIGN KEY (id_artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_invite ADD CONSTRAINT fk_f57b6785eaa19893 FOREIGN KEY (artist_author_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT fk_5a8a6c8d79f37ae5');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT fk_5a8a6c8d212c041e');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT fk_5a8a6c8d37a2b0df');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT fk_5a8a6c8d79f37ae5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT fk_5a8a6c8d212c041e FOREIGN KEY (id_event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT fk_5a8a6c8d37a2b0df FOREIGN KEY (id_artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artist DROP CONSTRAINT fk_1599687783e3463');
        $this->addSql('ALTER TABLE artist ADD CONSTRAINT fk_1599687783e3463 FOREIGN KEY (manager_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_3bae0aa733f585d2');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT fk_3bae0aa7eaa19893');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_3bae0aa733f585d2 FOREIGN KEY (id_concerthall_id) REFERENCES concert_hall (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_3bae0aa7eaa19893 FOREIGN KEY (artist_author_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
