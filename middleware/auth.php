<?php
session_start();

/**
 * Allow only logged-in users
 */
function requireLogin()
{
    if (!isset($_SESSION['user'])) {
        header("Location: ../pages/login.php");
        exit;
    }
}

/**
 * Allow only users with specific roles
 */
function requireRole($roles = [])
{
    if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], $roles)) {
        header("Location: ../pages/dashboard.php");
        exit;
    }
}

/**
 * Redirect back if already logged in (useful for login page)
 */
function guestOnly()
{
    if (isset($_SESSION['user'])) {
        header("Location: ../pages/dashboard.php");
        exit;
    }
}

/**
 * Check if user is NOT allowed to access something
 */
function blockRole($blockedRoles = [])
{
    if (isset($_SESSION['user']) && in_array($_SESSION['user']['role'], $blockedRoles)) {
        header("Location: ../pages/dashboard.php");
        exit;
    }
}

/**
 * Optional: simple permission checking (if you add permissions later)
 */
function requirePermission($permission)
{
    if (
        !isset($_SESSION['user']['permissions']) ||
        !in_array($permission, $_SESSION['user']['permissions'])
    ) {

        header("Location: ../pages/403.php");
        exit;
    }
}
