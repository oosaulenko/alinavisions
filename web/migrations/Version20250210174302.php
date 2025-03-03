<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210174302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio ADD photoshoot_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED10622191CB92 FOREIGN KEY (photoshoot_id) REFERENCES photoshoot (id)');
        $this->addSql('CREATE INDEX IDX_A9ED10622191CB92 ON portfolio (photoshoot_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE portfolio DROP FOREIGN KEY FK_A9ED10622191CB92');
        $this->addSql('DROP INDEX IDX_A9ED10622191CB92 ON portfolio');
        $this->addSql('ALTER TABLE portfolio DROP photoshoot_id');
    }
}
