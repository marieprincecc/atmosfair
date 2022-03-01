<?php

namespace App\test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class HomeWebTest extends WebTestCase
{
    public function testHomeVisiteur(): void
    {   
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('html', "Qui plante un jardin, plante le bonheur");


    }

    public function testHomeUser(): void
    {   
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('html', "Qui plante un jardin, plante le bonheur");
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('user@user.fr');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('html','Mes commandes');


    }

    public function testHomeAdministrateur(): void
    {   
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('html', "Qui plante un jardin, plante le bonheur");
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('admin@admin.fr');
        $client->loginUser($testUser);
        $crawler = $client->request('GET', 'admin/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('html', "Bienvenu dans votre administration");


    }
}