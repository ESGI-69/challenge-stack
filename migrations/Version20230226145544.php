<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226145544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_concert_hall (user_id INT NOT NULL, concert_hall_id INT NOT NULL, PRIMARY KEY(user_id, concert_hall_id))');
        $this->addSql('CREATE INDEX IDX_3EFEE0FAA76ED395 ON user_concert_hall (user_id)');
        $this->addSql('CREATE INDEX IDX_3EFEE0FAC8B57370 ON user_concert_hall (concert_hall_id)');
        $this->addSql('ALTER TABLE user_concert_hall ADD CONSTRAINT FK_3EFEE0FAA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_concert_hall ADD CONSTRAINT FK_3EFEE0FAC8B57370 FOREIGN KEY (concert_hall_id) REFERENCES concert_hall (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_concert_hall DROP CONSTRAINT FK_3EFEE0FAA76ED395');
        $this->addSql('ALTER TABLE user_concert_hall DROP CONSTRAINT FK_3EFEE0FAC8B57370');
        $this->addSql('DROP TABLE user_concert_hall');
    }
}
