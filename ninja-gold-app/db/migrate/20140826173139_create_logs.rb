class CreateLogs < ActiveRecord::Migration
  def change
    create_table :logs do |t|
      t.string :event
      t.references :user, index: true

      t.timestamps
    end
  end
end
