<?php

namespace App\Services\BitrixSupport\Ticket;

use CFile;
use CTicket;

class Ticket
{
	public function create(
		array|TicketFields $fields,
		bool $checkRights = false,
		bool $sendEmailToAuthor = true,
		bool $sendEmailToTechSupport = true
	): array {
		$id = CTicket::Set(
			is_array($fields) ? $fields : $fields->toArray(),
			$message_id,
			checkRights: $this->boolToString($checkRights),
			sendEmailToAuthor: $this->boolToString($sendEmailToAuthor),
			sendEmailToTechsupport: $this->boolToString($sendEmailToTechSupport)
		);

		return [
			'id' => $id,
			'message_id' => $message_id
		];
	}

	public function addMessageToExistTicked(
		array $fields,
		int $tickedId,
		bool $checkRights = false,
		bool $sendEmailToAuthor = true,
		bool $sendEmailToTechSupport = true
	): array {
		$id = CTicket::Set(
			$fields,
			$message_id,
			$tickedId,
			$this->boolToString($checkRights),
			$this->boolToString($sendEmailToAuthor),
			$this->boolToString($sendEmailToTechSupport)
		);

		return [
			'id' => $id,
			'message_id' => $message_id
		];
	}

	public function getById(int $id): false|array
	{
		$ticket = CTicket::GetByID($id, arParams: ["SELECT" => ["UF_*"]]);

		if (!$ticket) {
			return false;
		}

		return $ticket->Fetch();
	}

	public function getTicketMessages(int $id): array
	{
		$messages = [];
		$files = $this->getTicketFiles($id);

		foreach ($this->getMessagesListByTicketId($id) as $message) {
			// системное сообщение
			if ($message['IS_LOG'] === 'Y') {
				continue;
			}

			// скрытое сообщение
			if ($message['IS_HIDDEN'] === 'Y') {
				continue;
			}

			$messages[] = [
				'id' => $message['ID'],
				'message' => $message['MESSAGE'],
				'by_support' => $message['MESSAGE_BY_SUPPORT_TEAM'] === 'Y',
				'create_at' => $message['DATE_CREATE'],
				'crate_email' => $message['CREATED_EMAIL'] ?: $message['OWNER_SID'],
				'files' => $files[$message['ID']]
			];
		}

		return $messages;
	}

	public function getMessagesListByTicketId(int $id): array
	{
		$list = CTicket::GetMessageList(
			arFilter: ['TICKET_ID' => $id],
			checkRights: 'N'
		);

		if (!$list) {
			return [];
		}

		$messages = [];

		while ($message = $list->Fetch()) {
			$messages[] = $message;
		}

		return $messages;
	}

	public function getTicketFiles(int $id): array
	{
		$files = [];

		foreach ($this->getFilesListByTicketId($id) as $file) {
			$url = getSiteUrl() . '/bitrix/tools/ticket_show_file.php?hash='. $file['HASH'] .'&lang=' . LANGUAGE_ID;

			$files[$file['MESSAGE_ID']][] = [
				'name' => $file['FILE_NAME'],
				'message_id' => $file['MESSAGE_ID'],
				'size' => CFile::FormatSize($file['FILE_SIZE']),
				'url' => [
					'show' => $url,
					'download' => $url . '&action=download',
				],
			];
		}

		return $files;
	}

	public function getFilesListByTicketId(int $id): array
	{
		$list = CTicket::GetFileList(arFilter: [
			'TICKET_ID' => $id
		]);

		if (!$list) {
			return [];
		}

		$files = [];

		while ($file = $list->Fetch()) {
			$files[] = $file;
		}

		return $files;
	}

	private function boolToString(bool $val): string
	{
		return $val ? 'Y' : 'N';
	}
}