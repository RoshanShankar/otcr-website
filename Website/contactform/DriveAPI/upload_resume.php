<?php
require __DIR__ . '/../quickstart.php';

$client = getClient();
$driveService = new Google_Service_Drive($client);
$parentFolderId = getApplicationFolder($driveService);
createApplicantFolder($driveService, $parentFolderId, $_POST['name']);

function getApplicationFolder($driveService)
{
    //Find all folders/files in drive
    $pageToken = null;
    do {
        $response = $driveService->files->listFiles(array(
            'q' => "mimeType='application/vnd.google-apps.folder'",
            'spaces' => 'drive',
            'pageToken' => $pageToken,
            'fields' => 'nextPageToken, files(id, name)',
        ));

        //Find the folder that all the applicant information needs to be put in
        foreach ($response->files as $file) {
            if ($file->name == 'Applications')
            return $file->id;
        }
        $pageToken = $repsonse->pageToken;
    } while ($pageToken != null);
}

function createApplicantFolder($driveService, $parentFolderId, $studentName)
{
    //Create applicant folder on google drive
    $folderMetadata = new Google_Service_Drive_DriveFile(array(
        'name' => $studentName,
        'mimeType' => 'application/vnd.google-apps.folder',
        'parents' => array($parentFolderId)
    ));
    $folder = $driveService->files->create($folderMetadata, array(
        'mimeType' => 'application/vnd.google-apps.folder',
        'uploadType' => 'multipart',
        'fields' => 'id'));

    //Upload resume to cPanel
    $targetfolder = "resumes/";
    $file_type = $_FILES['file']['type'];
    if ($file_type === 'application/pdf') {
        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder . basename( $_FILES['file']['name']))) {
            //success
        } else {
            echo "Problem uploading file. Please try again;";
            break;
        }
    } else {
        echo "You may only upload PDF files.";
        break;
    }

    //Upload resume to google drive
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
        'name' => 'resume.pdf',
        'parents' => array($folder->id)
    ));
    $content = file_get_contents($targetfolder.basename( $_FILES['file']['name']));
    $file = $driveService->files->create($fileMetadata, array(
        'data' => $content,
        'mimeType' => 'application/pdf',
        'uploadType' => 'multipart',
        'fields' => 'id'));
    //SUBJECT TO CHANGE
    header('Location: application_successful.html');
}
?>