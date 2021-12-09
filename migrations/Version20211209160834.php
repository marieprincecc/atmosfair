<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211209160834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE orderdetails_product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orderdetails_product (orderdetails_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_8110F0834584665A (product_id), INDEX IDX_8110F0834A01DDC7 (orderdetails_id), PRIMARY KEY(orderdetails_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE orderdetails_product ADD CONSTRAINT FK_8110F0834584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orderdetails_product ADD CONSTRAINT FK_8110F0834A01DDC7 FOREIGN KEY (orderdetails_id) REFERENCES orderdetails (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
