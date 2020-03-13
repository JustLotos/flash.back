<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Deck;
use App\Entity\User;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use function assert;
use function in_array;

class DeckVoter extends Voter
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
        // if the attribute isn't one we support, return false
        if (! in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (! $subject instanceof Deck) {
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

        if (! $user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        $deck = $subject;
        assert($deck instanceof Deck);

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($deck, $user);
            case self::EDIT:
                return $this->canEdit($deck, $user);
        }

        throw new LogicException('This code should not be reached!');
    }

    private function canView(Deck $deck, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($deck, $user)) {
            return true;
        }

        // the Post object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        return false;
    }

    private function canEdit(Deck $deck, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $deck->getUser();
    }
}
