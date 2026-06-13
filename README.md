# 🛡️ RangeOps: Enterprise Purple Team Cyber Range

![Docker](https://img.shields.io/badge/Docker-Compose-blue?logo=docker)
![Wazuh](https://img.shields.io/badge/Wazuh-SIEM%2FXDR-orange?logo=wazuh)
![Bash](https://img.shields.io/badge/Bash-Telemetry%20Bridge-green?logo=gnu-bash)
![Status](https://img.shields.io/badge/Status-Active-success)
![License](https://img.shields.io/badge/License-MIT-yellow.svg)

**RangeOps** is an enterprise-grade **Purple Team homelab cyber range** designed to bridge the gap between **Red Team exploitation** and **Blue Team detection engineering**.

Built from the ground up, this environment provides a realistic playground to practice offensive security while simultaneously collecting, analyzing, and engineering defensive telemetry.

---

# 🏛️ Architecture Overview

RangeOps is built around four main pillars:

- 🛡️ **SIEM / XDR Monitoring (Wazuh)**
- 👑 **King of the Hill (KotH) Arena**
- 💻 **Boot2Root (B2R) Scenarios**
- 🚩 **CTF Lab Ecosystem**

---

# 🛡️ 1. SIEM Integration — Wazuh XDR

> The Blue Team Command Center

Monitoring containers is challenging because Docker isolates processes, filesystems, and networks.

RangeOps solves this problem using a custom **Docker Telemetry Bridge**.

## Features

### Agentless Container Monitoring

Uses:

- Docker shared volumes
- Bash shell wrappers
- `PROMPT_COMMAND`

to forward interactive shell activity from isolated containers into the Wazuh Manager.

Example telemetry:

```bash
whoami
id
sudo -l
bash -p
cat /root/king.txt
```

---

## Custom Detection Engineering

Includes:

- Custom Wazuh decoders
- OSRegex / PCRE2 patterns
- Custom detection rules

Severity range:

```
Level 3  → Informational
Level 12 → Privilege Escalation
Level 14 → Critical Incident
```

Mapped against:

- MITRE ATT&CK techniques
- Real-world kill chain stages

---

# 👑 2. King of the Hill Arena

> Competitive Persistence & Privilege Escalation

A volatile multi-attacker environment designed to simulate attacker competition.

## Objective

Attackers must:

1. Gain initial access
2. Escalate privileges
3. Maintain persistence
4. Capture the throne

The final objective:

```bash
/root/king.txt
```

---

## Purple Team Detection Flow

When an attacker executes:

```bash
echo "PLAYER_WINS" > /root/king.txt
```

The telemetry bridge detects the modification.

Wazuh generates:

```
Level 14 - EMERGENCY
```

simulating a real-world breach alert.

---

# 💻 3. Boot2Root (B2R) Scenarios

> Enterprise Exploitation Lab

RangeOps provides realistic vulnerable environments based on:

- Known CVEs
- Misconfigurations
- Privilege escalation paths

---

## Image Sources

### Vulhub

RangeOps uses:

https://github.com/vulhub/vulhub

for pre-built vulnerable Docker environments.

Examples:

- Jenkins
- Tomcat
- Redis
- Web applications

---

## Custom Docker Images

Custom targets are created using:

- Ubuntu
- Debian
- Bash provisioning scripts
- Dockerfiles


Used for scenarios such as:

- Weak SSH credentials
- SUID exploitation
- Linux privilege escalation
- Sudo misconfiguration

---

# Current Scenarios

## Jenkins CI/CD

**CVE-2018-1000861**

Attack chain:

```
Unauthenticated Access
        ↓
ACL Bypass
        ↓
Groovy ASTTest RCE
        ↓
Privilege Escalation
```

---

## Apache Tomcat WebDAV

**CVE-2017-12615**

Attack chain:

```
HTTP PUT Abuse
        ↓
Extension Bypass
        ↓
JSP Upload
        ↓
Remote Code Execution
```

---

# 🚩 4. CTF Lab Ecosystem

> Offensive + Defensive Training Ground

RangeOps is designed as a mirror:

Attackers perform exploitation.

Defenders analyze the artifacts.

---

## Training Goals

Learn:

- Reverse shell detection
- Command execution telemetry
- Bash behavior analysis
- Privilege escalation detection
- Forensic investigation

Useful for:

- CTF preparation
- Purple Team exercises
- SOC analyst training

---

# 🛠️ Tech Stack

| Component | Technology |
|---|---|
| SIEM/XDR | Wazuh 4.x |
| Container | Docker + Docker Compose |
| Host OS | Debian 13 / Ubuntu 22.04 |
| Network | ZeroTier + UFW |
| Telemetry | Bash + PROMPT_COMMAND |
| Targets | Vulhub + Custom Images |

---

# 🚀 Installation

## Clone Repository

```bash
git clone https://github.com/Psr354/rangeops.git

cd rangeops
```

---

## Deploy Wazuh

```bash
cd wazuh-docker/single-node

docker compose up -d
```

Wait until all services initialize.

---

## Deploy KotH Arena

```bash
cd ../../koth-arena

docker compose up -d --build
```

---

# 🎯 Purple Team Workflow

## 🔴 Red Team

Example:

```bash
ssh player@<TARGET_IP> -p 2222
```

Privilege escalation:

```bash
bash -p
```

Capture:

```bash
echo "PLAYER_WINS" > /root/king.txt
```

---

## 🔵 Blue Team

Open:

```
https://<HOST_IP>:8443
```

Navigate:

```
Threat Hunting
```

Query:

```kql
rule.id:"100051" OR rule.id:"100052"
```

Expected:

```
Privilege Escalation Alert
King File Modification Alert
```

---

# 📂 Directory Structure

```text
rangeops/

├── wazuh-docker/
│   └── Wazuh SIEM deployment

├── koth-arena/
│   ├── Dockerfile
│   ├── docker-compose.yml
│   └── koth-logs/

├── vulhub/
│   └── Vulnerable CVE environments

├── .gitignore

└── README.md
```

---

# 🤝 Contributing

Contributions are welcome.

To add a new scenario:

1. Fork repository

2. Create branch:

```bash
git checkout -b feature/new-scenario
```

3. Commit:

```bash
git commit -m "feat: add new CVE scenario"
```

4. Push:

```bash
git push origin feature/new-scenario
```

5. Open Pull Request

---

# 📄 License

This project is licensed under the MIT License.

See:

```
LICENSE
```

for details.
