using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace Agentdrink
{
    #region User
    public class User
    {
        #region Member Variables
        protected int _id_user;
        protected string _username;
        protected string _email;
        protected string _password;
        protected string _no_tlp_user;
        protected int _active;
        protected string _vkey;
        #endregion
        #region Constructors
        public User() { }
        public User(string username, string email, string password, string no_tlp_user, int active, string vkey)
        {
            this._username=username;
            this._email=email;
            this._password=password;
            this._no_tlp_user=no_tlp_user;
            this._active=active;
            this._vkey=vkey;
        }
        #endregion
        #region Public Properties
        public virtual int Id_user
        {
            get {return _id_user;}
            set {_id_user=value;}
        }
        public virtual string Username
        {
            get {return _username;}
            set {_username=value;}
        }
        public virtual string Email
        {
            get {return _email;}
            set {_email=value;}
        }
        public virtual string Password
        {
            get {return _password;}
            set {_password=value;}
        }
        public virtual string No_tlp_user
        {
            get {return _no_tlp_user;}
            set {_no_tlp_user=value;}
        }
        public virtual int Active
        {
            get {return _active;}
            set {_active=value;}
        }
        public virtual string Vkey
        {
            get {return _vkey;}
            set {_vkey=value;}
        }
        #endregion
    }
    #endregion
}