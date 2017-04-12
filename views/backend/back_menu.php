<ul class="nav nav-tabs">
	<li role="presentation" class="<?php echo ($this->data['table'] == '')? 'active' : ''; ?>"><a href="#">Home</a></li>
  	<li role="presentation" class="<?php echo ($this->data['table'] == 'users')? 'active' : ''; ?>"><a href="/backend/users">Users</a></li>
	<li role="presentation" class="<?php echo ($this->data['table'] == 'hotels')? 'active' : ''; ?>"><a href="/backend/hotels">Hotels</a></li>
	<li role="presentation" class="<?php echo ($this->data['table'] == 'languages')? 'active' : ''; ?>"><a href="/backend/languages">Languages</a></li>
  	<li role="presentation" class="<?php echo ($this->data['table'] == 'sections')? 'active' : ''; ?>"><a href="/backend/sections">Sections</a></li>
  	<li role="presentation" class="<?php echo ($this->data['table'] == 'questions')? 'active' : ''; ?>"><a href="/backend/questions">Questions</a></li>
  	<li role="presentation" class="<?php echo ($this->data['table'] == 'texts')? 'active' : ''; ?>"><a href="/backend/texts">Text</a></li>
</ul>