<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240609195557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE portfolio_media (portfolio_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_37748B49B96B5643 (portfolio_id), INDEX IDX_37748B49EA9FDD75 (media_id), PRIMARY KEY(portfolio_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE portfolio_media ADD CONSTRAINT FK_37748B49B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portfolio_media ADD CONSTRAINT FK_37748B49EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio_media DROP FOREIGN KEY FK_37748B49B96B5643');
        $this->addSql('ALTER TABLE portfolio_media DROP FOREIGN KEY FK_37748B49EA9FDD75');
        $this->addSql('DROP TABLE portfolio_media');
    }
}
