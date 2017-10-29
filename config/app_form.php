<?php
// https://book.cakephp.org/3.0/en/views/helpers/form.html#customizing-the-templates-formhelper-uses

return [
	'inputSubmit' => '<button type="submit" class="btn btn-primary" {{attrs}}>Envoyer</button>',
	'inputContainer' => '<DIV class="form-group">{{content}}</DIV>',
	'input' => '<input type="{{type}}" name="{{name}}" class="form-control" {{attrs}}/>',
	'select' => '<select name="{{name}}" class="form-control" {{attrs}}>{{content}}</select>',
	'textarea' => '<textarea name="{{name}}" class="form-control" {{attrs}}>{{value}}</textarea>',
	'nestingLabel' => '{{hidden}}<div class="form-check"><label class="form-check-label" {{attrs}}>{{input}} {{text}}</label></div>',
	'radio' => '<input type="radio" name="{{name}}" class="form-check-input" value="{{value}}" {{attrs}}>',
	'file' => '<input type="file" name="{{name}}" class="form-control" {{attrs}}>'
];
?>