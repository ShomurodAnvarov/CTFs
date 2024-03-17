from pyftpdlib.authorizers import DummyAuthorizer
from pyftpdlib.handlers import FTPHandler
from pyftpdlib.servers import FTPServer

def main():
    # Instantiate a dummy authorizer for managing 'virtual' users
    authorizer = DummyAuthorizer()

    # Define a new user having full read-only permissions
    authorizer.add_anonymous('...', perm='elr')

    # Instantiate FTP handler class
    handler = FTPHandler
    handler.authorizer = authorizer

    # Specify a range of passive ports (required for NAT traversal)
    handler.passive_ports = range(60000, 65535)

    # Instantiate FTP server class and listen on 0.0.0.0:100
    server = FTPServer(('0.0.0.0', 111), handler)

    # Start serving
    server.serve_forever()

if __name__ == '__main__':
    main()
