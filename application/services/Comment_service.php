<?php
	class Comment_service
	{
		private $ci;
		public function __construct()
		{
			$this->ci = &get_instance();
			$this->ci->load->model('Comment_model' , 'comment_model');
		}

		public function save_comment($comment_id , $comment)
		{
			if($comment_id == "")
			{
				$comment_id = $this->add_comment($comment);
			}
			else
			{
				$this->update_comment($comment_id , $comment);
			}
			return $comment_id;
		}

		public function add_comment($comment)
		{
			$comment['created_by'] = $this->ci->user_session->get_user_id();
			$comment['updated_by'] = $this->ci->user_session->get_user_id();

			$comment_id = $this->ci->comment_model->add_comment($comment);
			return $comment_id;
		}

		public function update_comment($comment_id , $comment)
		{
			$comment['updated_by'] = $this->ci->user_session->get_user_id();

			$this->ci->comment_model->update_comment($comment_id , $comment);
			return $comment_id;
		}

		public function get_comment($comment_id)
		{
			return $this->ci->comment_model->get_comment($comment_id);
		}

		public function get_user_comments($user_id , $public = "")
		{
			$comments = $this->ci->comment_model->get_user_comments($user_id , $public);
			$comments = $this->get_comments_objects($comments);
			return $comments;
		}

		public function get_status_comments($status)
		{
			$comments = $this->ci->comment_model->get_status_comments($status);
			$comments = $this->get_comments_objects($comments);
			return $comments;
		}

		public function get_role_comments($role)
		{
			$comments = $this->ci->comment_model->get_role_comments($role);
			$comments = $this->get_comments_objects($comments);
			$comments = array_reverse($comments);
			return $comments;
		}

		public function get_all_comments()
		{
			$comments = $this->ci->comment_model->get_all_comments(); 
			$comments = $this->get_comments_objects($comments);
			$comments = array_reverse($comments);
			return $comments;
		}

		public function get_recent_comments()
		{
			$criteria = new Criteria();
			$criteria->add_criteria(Comment_search_criteria::$ARCHIVE , 'N');
			$criteria->set_sort(Comment_sort_criteria::$AUTO_ID, false);
			$criteria->set_start_index(0);
			$criteria->set_count(10);
			$comments = $this->search_comments($criteria);
			$comments = $comments['result'];
			$comments = $this->get_comments_objects($comments);
			return $comments;
		}

		public function get_comment_details($comment_id)
		{
			$comment = $this->get_comment($comment_id);
			return $comment;
		}

		public function get_comment_map($comment_ids)
		{
			$comments =  $this->ci->comment_model->get_comments($comment_ids);
			return $this->ci->util->get_map('comment_id' , $comments);
		}

		public function delete_comment($comment_id)
		{
			return $this->ci->comment_model->delete_comment($comment_id);
		}

		public function search_comments($criterias)
		{
			return $this->ci->comment_model->search_comments($criterias);
		}

		public function get_comments_objects($comments)
		{
			$user_service = Factory::get_service('user_service');
			$users = [];
			for($i = 0 ; $i < count($comments) ; $i ++) {
				if(!$users[$comments[$i]['user_id']]) {
					$users[$comments[$i]['user_id']] = $user_service->get_user($comments[$i]['user_id']);
				}

				if(!$users[$comments[$i]['commenter_id']]) {
					$users[$comments[$i]['commenter_id']] = $user_service->get_user($comments[$i]['commenter_id']);
				}

				$comments[$i]['user'] = $users[$comments[$i]['user_id']];
				$comments[$i]['commenter'] = $users[$comments[$i]['commenter_id']];
				$comments[$i]['comment_html'] = nl2br($comments[$i]['comment']);
				$comments[$i]['time'] = format_time($comments[$i]['created_on']);
			}
			return $comments;
		}
	}
