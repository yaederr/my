class User < ActiveRecord::Base
	def do_activity activity
		change = 0
		if activity == "hunt" then change= Random.rand(11) end #0,10
		if activity == "farm" then change= Random.rand(6)+2 end #2,7
		if activity == "mine" then change= Random.rand(3)+3 end #3,5
		if activity == "gamble" #-50,20 with pr(40) lose
			change = Random.rand(21)-Random.rand(25)
		end
		self.update(gold: self.gold+change)
		if change > 0
			evt = "You went to "+activity+" and gained "+change.to_s+" gold."
	    else
	    	evt = "You went to "+activity+" and lost "+change.abs.to_s+" gold."
	    end
	    Log.new(user_id: self.id, event:evt).save
	end
	def get_log
		Log.where(user_id: self.id)
	end
end