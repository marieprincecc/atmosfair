<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211206124239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, order_id_id INT NOT NULL, user_id_id INT NOT NULL, orderdetail_id_id INT NOT NULL, UNIQUE INDEX UNIQ_90651744FCDAEAAA (order_id_id), INDEX IDX_906517449D86650F (user_id_id), INDEX IDX_9065174447BB9876 (orderdetail_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES orderbuy (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517449D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174447BB9876 FOREIGN KEY (orderdetail_id_id) REFERENCES orderdetails (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE invoice');
    }
}
