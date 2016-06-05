<?php

/**
 * job actions.
 *
 * @package    jobeet
 * @subpackage job
 * @author     Your name here
 */
class jobActions extends sfActions
{
    /**
     * Метод JobeetJobPeer::doSelect получает список вакансий из базы данных (как?)
     * и сохраняет их в массиве $JobeetJobs. $JobeetJobs доступен в шаблоне 
     * indexSuccess.php
     * 
     * @param sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request)
  {
        $this->categories = JobeetCategoryPeer::getWithJobs();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->job = $this->getRoute()->getObject();
  }

  public function executeNew(sfWebRequest $request)
  {
    $job = new JobeetJob();
    $job->setType('full-time');
    
    $this->form = new JobeetJobForm($job);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new JobeetJobForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->form = new JobeetJobForm($this->getRoute()->getObject());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->form = new JobeetJobForm($this->getRoute()->getObject());

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $job = $this->getRoute()->getObject();
    $job->delete();

    $this->redirect('job/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $job = $form->save();

      $this->redirect('job_show'.$job);
    }
  }
}
