<?php

namespace App\EventSubscriber;

use Doctrine\ORM\EntityNotFoundException;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception  = $event->getThrowable();
        $statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR; // 500 by default
        $message = "An internal error has occurred.";

        // Different types of errors
        if ($exception instanceof NotFoundHttpException) {
            $statusCode = JsonResponse::HTTP_NOT_FOUND; // 404
            $message = "Resource not found.";
        } elseif ($exception instanceof AccessDeniedHttpException) {
            $statusCode = JsonResponse::HTTP_FORBIDDEN; // 403
            $message = "Access denied.";
        } elseif ($exception instanceof AuthenticationException) {
            $statusCode = JsonResponse::HTTP_UNAUTHORIZED; // 401
            $message = "Authentication required.";
        } elseif ($exception instanceof InvalidArgumentException) {
            $statusCode = JsonResponse::HTTP_BAD_REQUEST; // 400
            $message = "Invalid data.";
        } elseif ($exception instanceof EntityNotFoundException) {
            $statusCode = JsonResponse::HTTP_NOT_FOUND;
            $message = "The requested entity does not exist.";
        } elseif ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            $message = $exception->getMessage();
        }

        // Error log
        $this->logger->error("API error : " . $exception->getMessage());

        // JSON response
        $response = new JsonResponse([
            "status" => $statusCode,
            "message" => $message
        ], $statusCode);

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
