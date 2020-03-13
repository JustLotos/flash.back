<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture implements ContainerAwareInterface
{
    private $passwordEncoder;

    public function loadData(ObjectManager $manager) : void
    {
        /** @var UserPasswordEncoderInterface $encoder */
        $this->passwordEncoder = $this->container->get('security.password_encoder');

        $this->createMany(1, 'admin', function () {
            $user = new User();
            $user->setEmail('ignashov-roman@mail.ru');
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                '123456'
            ));
            $user->setRoles(['ROLE_ADMIN']);

            return $user;
        });

        $this->createMany(2, 'users', function ($i) {
            $user = new User();
            $user->setEmail("test$i@mail.com");
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                '123456'
            ));

            return $user;
        });

        $manager->flush();
    }
}
