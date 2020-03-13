<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Card;
use App\Entity\User;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use function assert;
use function in_array;

class CardVoter extends Voter
{
    public const VIEW = 'view';
    public const EDIT = 'edit';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        if (! in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (! $subject instanceof Card) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // Доступа админа к включить только к разшаренным чужим колодам
        //        if ($this->security->isGranted('ROLE_ADMIN')) {
        //            return true;
        //        }

        $user = $token->getUser();
        assert($user instanceof User);

        if (! $user instanceof User) {
            return false;
        }

        $card = $subject;
        assert($card instanceof Card);

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($card, $user);
            case self::EDIT:
                return $this->canEdit($card, $user);
        }

        throw new LogicException('This code should not be reached!');
    }

    private function canView(Card $card, User $user)
    {
        if ($this->canEdit($card, $user)) {
            return true;
        }

        return false;
    }

    private function canEdit(Card $card, User $user)
    {
        // TODO протестировать доступ пользователя к карте
        return $user === $card->getDeck()->getUser();
    }
}
