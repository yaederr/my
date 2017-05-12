Rails.application.routes.draw do
	root 'users#index'
	get '/users/new' =>     'users#new',    :as=>:newgame
	get '/users/' =>        'users#index',  :as=>:user_list
	get '/users/:id' =>     'users#show',   :as=>:user
	get '/users/:id/edit'=> 'users#edit',   :as=>:change_form
	get '/users/:id/kill' =>'users#kill',   :as=>:kill_link
	post '/users' =>        'users#create'
	patch '/users/:id' =>   'users#change'
	put '/users/:id' =>     'users#change'
	get '/users/:id/changepw'=>'users#pw_form', :as=>:change_pw #just the view
	post '/users/:id/changepw' => 'users#do_change_pw', :as=>:post_change_pw
end