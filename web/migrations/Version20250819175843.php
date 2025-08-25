<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250819175843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE portfolio_category_media (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT NOT NULL, name VARCHAR(64) NOT NULL, sort INT NOT NULL, INDEX IDX_DE866A6AB96B5643 (portfolio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE portfolio_category_media ADD CONSTRAINT FK_DE866A6AB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio_category_media DROP FOREIGN KEY FK_DE866A6AB96B5643');
        $this->addSql('DROP TABLE portfolio_category_media');
    }
}
