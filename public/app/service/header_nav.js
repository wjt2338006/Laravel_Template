/**
 * Created by keith on 17-1-22.
 */

adminApp.service('HeaderNav', function () {
    var self = {
        navList: [
            {
                name: 'test',
                url: 'now',
                isNow:true
            }

        ],
        now: null
    };
    self.flush = function (list) {
        self.navList = list;
    };
    self.setNow = function (now) {
        for(var i in self.navList)
        {
            if(self.navList[i].name == now)
            {
                self.navList[i].isNow = true;
            }
            else
            {
                self.navList[i].isNow = false;
            }
        }
    };
    return self;
});