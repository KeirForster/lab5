<?php

class Views extends Application
{

    public function index()
    {
        $this->data['pagetitle'] = 'Ordered TODO List';
        $tasks = $this->tasks->all();   // get all the tasks
        $this->data['content'] = 'Ok'; // so we don't need pagebody
        $this->data['leftside'] = $this->makePrioritizedPanel($tasks);
        $this->data['rightside'] = $this->tasks->makeCategorizedPanel($tasks);

        $this->render('template_secondary');
    }

    function makePrioritizedPanel($tasks) {

        // extract the undone tasks
        foreach ($tasks as $task)
        {
            if ($task->status != 2)
                $incomplete[] = $task;
        }
        usort($incomplete, "orderByPriority");

        // substitute the priority name
        foreach ($incomplete as $task)
            $task->priority = $this->app->priority($task->priority);

//        $converted[] = (array) $task;
        $parms = ['display_tasks' => $incomplete];
				$role = $this->session->userdata('userrole');
				$parms['completer'] = ($role == ROLE_OWNER) ? '/views/complete' : '#';
        return $this->parser->parse('by_priority',$parms,true);
    }
	
		function complete() {
			$role = $this->session->userdata('userrole');
			if ($role != ROLE_OWNER) redirect('/views');
			
			foreach($this->input->post() as $key=>$value) {
                if (substr($key,0,4) == 'task') {
												$taskid = substr($key,4);
												$task = $this->tasks->get($taskid);
												$task->status = 2; // complete
												$this->tasks->update($task);
                }
        }
        $this->index();
		}
}

// return -1, 0, or 1 of $a's priority is higher, equal to, or lower than $b's
function orderByPriority($a, $b)
{
    if ($a->priority > $b->priority)
        return -1;
    elseif ($a->priority < $b->priority)
        return 1;
    else
        return 0;
}