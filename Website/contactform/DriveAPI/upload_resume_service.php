<?php
require __DIR__ . '/vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=Drive API-1907d83e8710.json');
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setScopes(['https://www.googleapis.com/auth/drive']);
$client->setAccessType('offline');
$service = new Google_Service_Drive($client);
$optParams = array(
    'pageSize' => 10,
    'fields' => 'nextPageToken, files(id, name)'
  );
  $results = $service->files->listFiles($optParams);
  
  if (count($results->getFiles()) == 0) {
      print "No files found.\n";
  } else {
      print "Files:\n";
      foreach ($results->getFiles() as $file) {
          printf("%s (%s)\n", $file->getName(), $file->getId());
      }
  }
//$driveService = new Google_Service_Drive($client);
//$parentFolderId = getApplicationFolder($driveService);
//printf($parentFolderId);
// createApplicantFolder($driveService, $parentFolderId, "Mihir");


function createApplicantFolder($driveService, $parentFolderId, $studentName)
{
    //create applicant folder on google drive
    $folderMetadata = new Google_Service_Drive_DriveFile(array(
        'name' => $studentName,
        'mimeType' => 'application/vnd.google-apps.folder',
        'parents' => array($parentFolderId)));
    $folder = $driveService->files->create($folderMetadata, array(
        'mimeType' => 'application/vnd.google-apps.folder',
        'uploadType' => 'multipart',
        'fields' => 'id'));
    //upload resume to cPanel
    $targetCpanelfolder = "resumes/";
    $targetCpanelfolder = $targetCpanelfolder . basename( $_FILES['file']['name']) ;
    $ok = 1;
    $file_type=$_FILES['file']['type'];
    if ($file_type=="application/pdf")
    {
        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetCpanelfolder))
        {
            echo "The file ". basename( $_FILES['file']['name']). " is uploaded";
        }
        else
        {
            echo "Problem uploading file";
        }
    }
    else
    {
        echo "You may only upload PDFs.<br>";
    }
    //upload resume to google drive
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
        'name' => 'resume.pdf',
        'parents' => array($folder->id)
    ));
    $content = file_get_contents('resume/'.basename( $_FILES['file']['name']));
    $file = $driveService->files->insert($fileMetadata, array(
        'data' => $content,
        'mimeType' => 'application/pdf',
        'uploadType' => 'multipart',
        'fields' => 'id'));
    echo "Uploaded!";
}

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
?>