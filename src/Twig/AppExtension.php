<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AppExtension extends AbstractExtension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param RequestStack $requestStack 
     * @param SessionInterface $session 
     * @return void 
     */
    public function __construct(RequestStack $requestStack, SessionInterface $session)
    {
        $this->requestStack = $requestStack;
        $this->session = $session;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('set_active_route', [$this, 'setActiveRoute']),
        ];
    }

    /**
     * Si la route courrante correspond à la route demandée retourne la class qui peut être
     * passée en paramètres par défaut = active
     * @param string $route 
     * @param null|string $activeClass
     * 
     * @return string 
     */
    public function setActiveRoute(string $route, ?string $activeClass = 'active'): string
    {
        $currentRoute = $this->requestStack->getCurrentRequest()->attributes->get('_route');
        return (strpos($currentRoute, $route, 0) !== false) ? $activeClass : '';
    }
}
