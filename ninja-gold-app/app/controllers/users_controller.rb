class UsersController < ApplicationController
  respond_to :html, :xml, :json
  def new
    @user = User.new
  end
  def create
    @user = User.new(name:user_params[:name], gold:0)
    @user.save
    redirect_to @user
  end
  def show
    @user = User.find_by_id(params[:id])
  end

  def index
    @users = User.all
  end

  def activity #this handles user quests (hunt, farm, mine, gamble)
    user = User.find_by_id(params[:id])
    user.do_activity params[:activity]
  end

  def get_gold
    @user = User.find_by_id(params[:id])
    render :json => @user
  end
  def get_log
    user = User.find_by_id(params[:id])#the model must get the log
    render :json => user.get_log
  end

  private
    def user_params
      params.require(:user).permit(:name)
    end
end
