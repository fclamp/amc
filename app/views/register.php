

<h2>Register!</h2>

<?php echo Form::open(array('url'=>'/reg','method'=>'post')) ?>

<?php echo Form::label('username', 'Username') . Form::text('username', Input::old('username')) ?>
<?php echo $errors->first('username'); ?>

<?php echo Form::label('email', 'E-mail') . Form::text('email', Input::old('email')) ?>
<?php echo $errors->first('email'); ?>

<?php echo Form::label('password', 'Password') . Form::password('password') ?>

<?php echo Form::submit('Register!') ?>

<?php echo Form::close() ?>