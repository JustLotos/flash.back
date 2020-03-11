<?php


namespace App\Security;

use App\Entity\Card;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class CardVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

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
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Card) {
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

        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Card $card */
        $card = $subject;


        switch ($attribute) {
            case self::VIEW:
                return $this->canView($card, $user);
            case self::EDIT:
                return $this->canEdit($card, $user);
        }

        throw new \LogicException('This code should not be reached!');
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
        #TODO протестировать доступ пользователя к карте
        return $user === $card->getDeck()->getUser();
    }
}
