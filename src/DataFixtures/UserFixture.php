<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }


    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('redacteur');
        $user->setRoles(['ROLE_REDACTEUR']);
        $user->setPassword($this->passwordEncoder->encodePassword(
                         $user,
                        'redacteur'
                     ));
        $user->setEmail('redacteur@gmail.com');
        $user->setCreatedAt(new \DateTime());

        $user2 = new User();
        $user2->setUsername('admin');
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setPassword($this->passwordEncoder->encodePassword(
                         $user2,
                        'admin'
                     ));
        $user2->setEmail('admin@gmail.com');
        $user2->setCreatedAt(new \DateTime());

        $manager->persist($user2);
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername('user1');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword(
                         $user,
                        'user1'
                     ));
        $user->setEmail('user1@gmail.com');
        $user->setCreatedAt(new \DateTime());

        $user2 = new User();
        $user2->setUsername('user2');
        $user2->setRoles(['ROLE_USER']);
        $user2->setPassword($this->passwordEncoder->encodePassword(
                         $user2,
                        'user2'
                     ));
        $user2->setEmail('user2@gmail.com');
        $user2->setCreatedAt(new \DateTime());

        $manager->persist($user2);
        $manager->persist($user);
        $manager->flush();
    }
}
