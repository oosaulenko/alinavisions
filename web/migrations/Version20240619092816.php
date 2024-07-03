<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619092816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio CHANGE feature_image image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED10623DA5256D FOREIGN KEY (image_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_A9ED10623DA5256D ON portfolio (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio DROP FOREIGN KEY FK_A9ED10623DA5256D');
        $this->addSql('DROP INDEX IDX_A9ED10623DA5256D ON portfolio');
        $this->addSql('ALTER TABLE portfolio CHANGE image_id feature_image INT DEFAULT NULL');
    }
}
