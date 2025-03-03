<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210093728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photoshoot (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(200) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photoshoot_media (photoshoot_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_22B83B832191CB92 (photoshoot_id), INDEX IDX_22B83B83EA9FDD75 (media_id), PRIMARY KEY(photoshoot_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photoshoot_media ADD CONSTRAINT FK_22B83B832191CB92 FOREIGN KEY (photoshoot_id) REFERENCES photoshoot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photoshoot_media ADD CONSTRAINT FK_22B83B83EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photoshoot_media DROP FOREIGN KEY FK_22B83B832191CB92');
        $this->addSql('ALTER TABLE photoshoot_media DROP FOREIGN KEY FK_22B83B83EA9FDD75');
        $this->addSql('DROP TABLE photoshoot');
        $this->addSql('DROP TABLE photoshoot_media');
    }
}
