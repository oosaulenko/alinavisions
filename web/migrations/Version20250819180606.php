<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250819180606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE portfolio_medias (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT NOT NULL, media_id INT NOT NULL, category_id INT DEFAULT NULL, INDEX IDX_143942B4B96B5643 (portfolio_id), INDEX IDX_143942B4EA9FDD75 (media_id), INDEX IDX_143942B412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE portfolio_medias ADD CONSTRAINT FK_143942B4B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('ALTER TABLE portfolio_medias ADD CONSTRAINT FK_143942B4EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE portfolio_medias ADD CONSTRAINT FK_143942B412469DE2 FOREIGN KEY (category_id) REFERENCES portfolio_category_media (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio_medias DROP FOREIGN KEY FK_143942B4B96B5643');
        $this->addSql('ALTER TABLE portfolio_medias DROP FOREIGN KEY FK_143942B4EA9FDD75');
        $this->addSql('ALTER TABLE portfolio_medias DROP FOREIGN KEY FK_143942B412469DE2');
        $this->addSql('DROP TABLE portfolio_medias');
    }
}
