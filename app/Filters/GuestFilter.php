<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class GuestFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null): mixed
    {
        // Change the debug line to this:

        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRedirect());
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): void
    {
        // Nothing to do here.
    }
}