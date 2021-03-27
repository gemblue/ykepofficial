<?php

/** 
 * Custom Hook
 * 
 * function topaction_taskname() for entry action
 * function rowaction_actionname() for action per data row 
 */

class QuestionEntryActions {

	public function rowaction_accept_request($EntryModel, $id)
	{
		$entryData = $EntryModel->get($id);
		$EntryModel->where('id', $entryData['id'])->set('status', 'accepted')->update();
		
		return ['message' => '<div class="alert alert-success">Successfully approved.</div>'];
	}

	public function rowaction_decline_request($EntryModel, $id, $data = [])
	{
		$entryData = $EntryModel->get($id);
		$EntryModel->where('id', $entryData['id'])->set('status', 'declined')->update();

		return ['message' => '<div class="alert alert-success">Successfully declined.</div>'];
	}

	public function sendNotification($EntryModel, $data)
	{
		return $data;
	}
}