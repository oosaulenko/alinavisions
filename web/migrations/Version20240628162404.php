<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628162404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE package_media (package_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_FF28A6EBF44CABFF (package_id), INDEX IDX_FF28A6EBEA9FDD75 (media_id), PRIMARY KEY(package_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE package_media ADD CONSTRAINT FK_FF28A6EBF44CABFF FOREIGN KEY (package_id) REFERENCES package (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package_media ADD CONSTRAINT FK_FF28A6EBEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE package_media DROP FOREIGN KEY FK_FF28A6EBF44CABFF');
        $this->addSql('ALTER TABLE package_media DROP FOREIGN KEY FK_FF28A6EBEA9FDD75');
        $this->addSql('DROP TABLE package_media');
    }
}
