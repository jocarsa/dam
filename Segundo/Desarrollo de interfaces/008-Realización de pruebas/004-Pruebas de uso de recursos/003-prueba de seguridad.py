import requests
import ssl
import socket
from datetime import datetime
from urllib.parse import urlparse

# Function to check SSL certificate
def check_ssl_certificate(url):
    parsed_url = urlparse(url)
    hostname = parsed_url.hostname
    port = parsed_url.port or 443
    context = ssl.create_default_context()
    try:
        with socket.create_connection((hostname, port), timeout=10) as sock:
            with context.wrap_socket(sock, server_hostname=hostname) as ssock:
                cert = ssock.getpeercert()
                ssl_info = {
                    'subject': dict(x[0] for x in cert['subject']),
                    'issuer': dict(x[0] for x in cert['issuer']),
                    'version': cert.get('version'),
                    'serialNumber': cert.get('serialNumber'),
                    'notBefore': cert.get('notBefore'),
                    'notAfter': cert.get('notAfter'),
                }
                # Convert date strings to datetime objects
                ssl_info['notBefore'] = datetime.strptime(ssl_info['notBefore'], '%b %d %H:%M:%S %Y %Z')
                ssl_info['notAfter'] = datetime.strptime(ssl_info['notAfter'], '%b %d %H:%M:%S %Y %Z')
                ssl_info['is_valid'] = ssl_info['notAfter'] > datetime.utcnow()
                return ssl_info
    except Exception as e:
        return {'error': str(e)}

# Function to check HTTP security headers
def check_security_headers(url):
    try:
        response = requests.get(url, timeout=10)
        headers = response.headers
        security_headers = {
            'Content-Security-Policy': headers.get('Content-Security-Policy'),
            'Strict-Transport-Security': headers.get('Strict-Transport-Security'),
            'X-Frame-Options': headers.get('X-Frame-Options'),
            'X-Content-Type-Options': headers.get('X-Content-Type-Options'),
            'Referrer-Policy': headers.get('Referrer-Policy'),
            'Permissions-Policy': headers.get('Permissions-Policy'),
        }
        return security_headers
    except Exception as e:
        return {'error': str(e)}

# Function to get server banner
def get_server_banner(url):
    try:
        response = requests.get(url, timeout=10)
        server = response.headers.get('Server')
        return server
    except Exception as e:
        return {'error': str(e)}

# Function to perform basic port scanning
def basic_port_scan(hostname, ports=[80, 443]):
    open_ports = []
    for port in ports:
        try:
            with socket.create_connection((hostname, port), timeout=3):
                open_ports.append(port)
        except:
            pass
    return open_ports

# Main security check function
def security_check(url):
    print(f"Performing security checks for: {url}\n")
    
    # Parse URL
    parsed_url = urlparse(url)
    hostname = parsed_url.hostname
    
    # SSL Certificate Check
    print("1. SSL Certificate Check:")
    ssl_info = check_ssl_certificate(url)
    if 'error' in ssl_info:
        print(f"   Error: {ssl_info['error']}")
    else:
        print(f"   Subject: {ssl_info['subject']}")
        print(f"   Issuer: {ssl_info['issuer']}")
        print(f"   Valid From: {ssl_info['notBefore']}")
        print(f"   Valid Until: {ssl_info['notAfter']}")
        print(f"   SSL Certificate is {'valid' if ssl_info['is_valid'] else 'expired'}")
    print("\n")
    
    # HTTP Security Headers Check
    print("2. HTTP Security Headers Check:")
    headers = check_security_headers(url)
    if 'error' in headers:
        print(f"   Error: {headers['error']}")
    else:
        for header, value in headers.items():
            status = "Present" if value else "Missing"
            print(f"   {header}: {status}")
            if value:
                print(f"      Value: {value}")
    print("\n")
    
    # Server Banner Information
    print("3. Server Banner Information:")
    server = get_server_banner(url)
    if isinstance(server, dict) and 'error' in server:
        print(f"   Error: {server['error']}")
    else:
        print(f"   Server: {server if server else 'Not disclosed'}")
    print("\n")
    
    # Basic Port Scan
    print("4. Basic Port Scan:")
    open_ports = basic_port_scan(hostname)
    if open_ports:
        print(f"   Open Ports: {', '.join(str(port) for port in open_ports)}")
    else:
        print("   No common ports are open.")
    print("\n")

if __name__ == "__main__":
    import argparse

    parser = argparse.ArgumentParser(description="Basic Security Check Program for Web Servers")
    parser.add_argument('url', help='URL of the web server to check (e.g., https://www.example.com)')
    args = parser.parse_args()

    security_check(args.url)
