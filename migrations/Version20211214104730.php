<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211214104730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opinions ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE opinions ADD CONSTRAINT FK_BEAF78D0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BEAF78D0A76ED395 ON opinions (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opinions DROP FOREIGN KEY FK_BEAF78D0A76ED395');
        $this->addSql('DROP INDEX IDX_BEAF78D0A76ED395 ON opinions');
        $this->addSql('ALTER TABLE opinions DROP user_id');
    }
}
