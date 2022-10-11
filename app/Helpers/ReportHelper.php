<?php

namespace App\Helpers;

use App\Models\Report;
use App\Models\ReportFolder;
use DateInterval;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class ReportHelper
{
    /**
     * @param       $folderIds
     * @param array $rootFolderIds
     *
     * @return array
     */
    public static function getRootParentFolders($folderIds, array $rootFolderIds = [])
    {
        if (ReportFolder::whereIn('id', $folderIds)->whereNotNull('parent_id')->exists()) {
            $parentFolderIds = ReportFolder::whereIn('id', $folderIds)->pluck('parent_id')->toArray();

            $rootFolderIds = array_merge($rootFolderIds, ReportFolder::root()->whereIn('id', $folderIds)->pluck('id')->toArray());

            return self::getRootParentFolders($parentFolderIds, $rootFolderIds);
        }

        return array_merge($rootFolderIds, $folderIds);
    }

    /**
     * @param ReportFolder $maxLevelFolder
     * @param              $folderIds
     * @param array        $maxLevelFolderSubfolderIds
     *
     * @return array
     */
    public static function getSpecificFolderSubfolders(ReportFolder $maxLevelFolder, $folderIds, array $maxLevelFolderSubfolderIds = [])
    {
        if (ReportFolder::whereIn('id', $folderIds)->where('parent_id', '!=', $maxLevelFolder->id)->exists()) {
            $parentFolderIds = ReportFolder::whereIn('id', $folderIds)->pluck('parent_id')->toArray();

            $maxLevelFolderSubfolderIds = array_merge($maxLevelFolderSubfolderIds, ReportFolder::whereIn('id', $folderIds)->where('parent_id', $maxLevelFolder->id)->pluck('id')->toArray());

            return self::getSpecificFolderSubfolders($maxLevelFolder, $parentFolderIds, $maxLevelFolderSubfolderIds);
        }

        return $maxLevelFolderSubfolderIds;
    }

    /**
     * @param Report $report
     *
     * @return string
     */
    public static function getMetabaseIframeUrl(Report $report): string
    {
        $url = env('METABASE_SITE_URL');
        $secretKey = env('METABASE_SECRET_KEY');

        $key = InMemory::plainText($secretKey);
        $config = Configuration::forSymmetricSigner(new Sha256(), $key);

        $token = $config->builder()
            ->withClaim('resource', [
                'dashboard' => $report->metabase_id,
            ])
            ->withClaim('params', (object) [])
            ->expiresAt((new DateTimeImmutable())->add(new DateInterval('PT10M'))) // Adding 10 minutes
            ->getToken($config->signer(), $config->signingKey())
            ->toString();

        return $url . '/embed/dashboard/' . $token . '#bordered=false&titled=false';
    }
}
