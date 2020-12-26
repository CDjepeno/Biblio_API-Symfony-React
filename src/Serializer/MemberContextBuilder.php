<?php

namespace App\Serializer;

use App\Entity\Member;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class MemberRentContextBuilder implements SerializerContextBuilderInterface
{
    private $decorated;
    private $authorizationChecker;

    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->decorated            = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context       = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $resourceClass = $context['resource_class'] ?? null;

        if ($resourceClass === Member::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_MANAGER') &&  $normalization === true) {
            $context['groups'][] = 'get_role_manager';
        }
        if ($resourceClass === Member::class && isset($context['groups'])) {
            if($request->getMethod() == "POST"){
                $context['groups'][] = 'post_admin';
            } elseif($request->getMethod()=="PUT"){
                $context['groups'][] = 'put_admin';
            }
           
        }
        return $context;
    }
}